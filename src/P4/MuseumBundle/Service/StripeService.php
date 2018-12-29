<?php

namespace P4\MuseumBundle\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManager;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

class StripeService
{
	private $session;
	private $router;
	private $request;
	private $mailer;
	private $twig;
	private $manager;
	private $translator;

	public function __construct(SessionInterface $session, RouterInterface $router, RequestStack $requestStack, \Swift_Mailer $mailer, \Twig_Environment $twig, EntityManager $manager, TranslatorInterface $translator)
	{
		$this->session = $session;
		$this->router = $router;
		$this->request = $requestStack;
		$this->mailer = $mailer;
		$this->twig = $twig;
		$this->manager = $manager;
		$this->translator = $translator;
	}

	public function getOrder($order)
	{
		$id = $this->session->get('orderid');
		$em = $this->manager;
		$order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
		return $order;

	}
	public function checkoutOrders()
	{
			// Récupération des variables
		    $mail = $this->session->get('mail');
            $totalprice = $this->session->get('totalprice');
            $totalprice = $totalprice*100;

            $request = $this->request->getCurrentRequest();
            $token = $request->get('stripeToken');
            $id = $this->session->get('orderid');
            /*$locale = $request->getLocale();
            var_dump($locale); die;*/


           	$em = $this->manager;
	        $order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
	        $paymentstatus = $order->getPaymentstatus();

            // Création de la facture
            if($paymentstatus != 1) // Si le paiement n'a pas encore été effectué
            {
	            try {
		            \Stripe\Stripe::setApiKey("sk_test_6sEQ3QTQuRwTOEj7KCipjLKI"); 
		             \Stripe\Charge::create(array(
		              "amount" => $totalprice,
		              "currency" => "eur",
		              "source" => $token, // obtenu avec Stripe.js
		              "description" => "Facture pour " .$this->session->get('firstname'). ".",
		              "receipt_email" => $mail),
		              array("idempotency_key" => (sha1(random_bytes(20)))));

		              $message = (new \Swift_Message('Votre commande'))
		            ->setFrom('arnaud.griess@orange.fr')
		            ->setTo($mail)
		            ->setBody(
		                $this->twig->render('P4MuseumBundle:Ticket:mail.html.twig', array('mail' => $mail,
		                                                                                'order' => $order)),
		                'text/html');
		            $this->mailer->send($message);
		            $order->setPaymentstatus(1);
		            $em->persist($order);
		            $em->flush();
		            $this->session->clear();
		             //Rédirection vers la page de confirmation
		             return new RedirectResponse($this->router->generate('p4_museum_confirm'));
		             // Suppression de la session
	         	}

	         	// Gestion des erreurs
	            catch(\Stripe\Error\Card $e) {
	                  $body = $e->getJsonBody();
	                  $err  = $body['error'];

	                  switch($err['code']){
	                    case 'insufficient_funds':
	                        $this->session->getFlashBag()->add('notice', $this->translator->trans('error.payment.declined'));
	                        break;
	                    case 'incorrect_cvc':
	                        $this->session->getFlashBag()->add('notice', $this->translator->trans('error.payment.incorrect_cvc'));
	                        break;
	                    case 'expired_card':
	                        $this->session->getFlashBag()->add('notice', $this->translator->trans('error.payment.expired_card'));
	                        break;
	                    case 'processing_error':
	                        $this->session->getFlashBag()->add('notice', $this->translator->trans('error.payment.processing_error'));
	                        break;
	                    default:
	                        $this->session->getFlashBag()->add('notice', $this->translator->trans('error.payment.default'));
	                        break;
	                    }
	            }
	           }

          else {
				$this->session->getFlashBag()->add('notice', 'Paiement déjà effectué');  
          }

            // Si des erreurs sont détectées, redirection vers la page "checkout" et affichage d'un message d'erreur
            return new RedirectResponse($this->router->generate('p4_museum_checkout'));
	}
}

