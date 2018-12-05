<?php

namespace P4\MuseumBundle\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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

	public function __construct(SessionInterface $session, RouterInterface $router, RequestStack $requestStack, \Swift_Mailer $mailer, \Twig_Environment $twig, EntityManager $manager)
	{
		$this->session = $session;
		$this->router = $router;
		$this->request = $requestStack;
		$this->mailer = $mailer;
		$this->twig = $twig;
		$this->manager = $manager;
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
            // Création de la facture
            try {
	            \Stripe\Stripe::setApiKey("sk_test_6sEQ3QTQuRwTOEj7KCipjLKI"); 
	             \Stripe\Charge::create(array(
	              "amount" => $totalprice,
	              "currency" => "eur",
	              "source" => $token, // obtenu avec Stripe.js
	              "description" => "Facture pour " .$this->session->get('firstname'). ".",
	              "receipt_email" => $mail),
	              array("idempotency_key" => (sha1(random_bytes(20)))));

	             //Envoi de l'e-mail de confirmation
	              $em = $this->manager;
	              $order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
	              $message = (new \Swift_Message('Votre commande'))
	            ->setFrom('arnaud.griess@orange.fr')
	            ->setTo($mail)
	            ->setBody(
	                $this->twig->render('P4MuseumBundle:Ticket:mail.html.twig', array('mail' => $mail,
	                                                                                'order' => $order)),
	                'text/html');
	            $this->mailer->send($message);
	             //Rédirection vers la page de confirmation
	             return new RedirectResponse($this->router->generate('p4_museum_confirm'));
	             $session->clear(); // Suppression de la session
         	}

         	// Gestion des erreurs
            catch(\Stripe\Error\Card $e) {
                  $body = $e->getJsonBody();
                  $err  = $body['error'];

                  switch($err['code']){
                    case 'card_declined':
                        $this->session->getFlashBag()->add('notice', 'Paiement refusé.');
                        break;
                    case 'incorrect_cvc':
                        $this->session->getFlashBag()->add('notice', 'Le code de sécurité de la carte est invalide');
                        break;
                    case 'expired_card':
                        $this->session->getFlashBag()->add('notice', 'Paiement refusé : le solde de votre compte bancaire est insuffisant pour finaliser cette transaction.');
                        break;
                    case 'processing_error':
                        $this->session->getFlashBag()->add('notice', 'Une erreur est survenue. Merci de vérifier les informations saisies ou modifier votre moyen de paiement.');
                        break;
                    default:
                        $this->session->getFlashBag()->add('notice', 'Une erreur est survenue.');
                        break;
                    }
            }

            // Si des erreurs sont détectées, redirection vers la page "checkout" et affichage d'un message d'erreur
            return new RedirectResponse($this->router->generate('p4_museum_checkout'));
	}
}

