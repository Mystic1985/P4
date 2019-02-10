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
use P4\MuseumBundle\Service\MailService;

class StripeService
{
	private $session;
	private $router;
	private $request;
	private $twig;
	private $manager;
	private $translator;
	private $secretKey;
	private $mailservice;

	public function __construct(SessionInterface $session, RouterInterface $router, Request $request, \Twig_Environment $twig, EntityManager $manager, TranslatorInterface $translator, $secretKey, MailService $mailservice)
	{

		$this->session = $session;
		$this->router = $router;
		$this->request = $request;
		$this->twig = $twig;
		$this->manager = $manager;
		$this->translator = $translator;
		$this->secretKey = $secretKey;
		$this->mailservice = $mailservice;
	}

	public function checkoutOrders()
	{
		// Récupération des variables
		$mail = $this->session->get('mail');
        $totalprice = $this->session->get('totalprice');
        $totalprice = $totalprice*100;

        $request = $this->request;
        $token = $request->get('stripeToken');
        $id = $this->session->get('orderid');

        $em = $this->manager;
	    $order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
	    $paymentstatus = $order->getPaymentstatus();

            // Création de la facture
        if($paymentstatus != 1) // Si le paiement n'a pas encore été effectué
        {
	        try {
	            $this->setStripeApiKey();
                $this->createStripeCharge($totalprice, $token, $mail);

		        $this->mailservice->sendConfirmMessage($order);
		         //Redirection vers la page de confirmation
		        return new RedirectResponse($this->router->generate('p4_museum_confirm'));
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

	protected function setStripeApiKey(): void
    {
        \Stripe\Stripe::setApiKey($this->secretKey);
    }

    /**
     * @param $totalprice
     * @param $token
     * @param $mail
     * @throws \Exception
     */
    protected function createStripeCharge($totalprice, $token, $mail): void
    {
        \Stripe\Charge::create(array(
            "amount" => $totalprice,
            "currency" => "eur",
            "source" => $token, // obtenu avec Stripe.js
            "description" => "Facture pour " . $this->session->get('firstname') . ".",
            "receipt_email" => $mail),
            array("idempotency_key" => (sha1(random_bytes(20)))));
    }
}

