<?php

// src/P4/MuseumBundle/Controller/TicketController.php

namespace P4\MuseumBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;
use P4\MuseumBundle\Entity\Ticketowner;
use P4\MuseumBundle\Entity\Ticket;
use P4\MuseumBundle\Entity\Customer;
use P4\MuseumBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\MuseumBundle\Form\TicketownerType;
use P4\MuseumBundle\Form\TicketType;
use P4\MuseumBundle\Form\CustomerType;
use P4\MuseumBundle\Form\OrdersType;
use P4\MuseumBundle\Form\AdressType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\ParameterBag;

class TicketController extends Controller
{   
    public function checkoutAction(Request $request)
    {
        $session = $request->getSession();

            $mail = $session->get('mail');
            $price = $session->get('price');
            $price = $price*100;

        if ($request->isMethod('POST')){

            \Stripe\Stripe::setApiKey("sk_test_6sEQ3QTQuRwTOEj7KCipjLKI");    

            $token = $request->get('stripeToken');
            try{
            \Stripe\Charge::create(array(
              "amount" => $price,
              "currency" => "eur",
              "source" => $token, // obtained with Stripe.js
              "description" => "Charge for " .$session->get('firstname'). ".",
              "receipt_email" => $mail),
              array("idempotency_key" => (sha1(random_bytes(20)))));

            $mail = $session->get('mail');
            $message = (new \Swift_Message('Hello Email'))
            ->setFrom('arnaud.griess@orange.fr')
            ->setTo($mail)
            ->setBody(
                $this->renderView('P4MuseumBundle:Ticket:mail.html.twig'),
                'text/html');
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('p4_museum_confirm');
            }
            catch(\Stripe\Error\Card $e) {
                  $body = $e->getJsonBody();
                  $err  = $body['error'];

                  switch($err['code']){
                    case 'card_declined':
                        $session->getFlashBag()->add('notice', 'Paiement refusé.');
                        break;
                    case 'incorrect_cvc':
                        $session->getFlashBag()->add('notice', 'Le code de sécurité de la carte est invalide');
                        break;
                    case 'expired_card':
                        $session->getFlashBag()->add('notice', 'Paiement refusé : le solde de votre compte bancaire est insuffisant pour finaliser cette transaction.');
                        break;
                    case 'processing_error':
                        $session->getFlashBag()->add('notice', 'Une erreur est survenue. Merci de vérifier les informations saisies ou modifier votre moyen de paiement.');
                        break;
                    }
            }
        }

            return $this->render('P4MuseumBundle:Ticket:checkout.html.twig');

    }
    public function indexAction(Request $request)
    {
    return $this->render('P4MuseumBundle:Ticket:index.html.twig');
    }

    public function buyAction(Request $request)
    {
        $session = new Session();
        // On crée un objet Orders
        $order = new Orders();
        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(OrdersType::class, $order);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

          $em = $this->getDoctrine()->getManager();
          $em->persist($order);
          $em->flush(); 
          // Flush des informations
          //Récupération des variables de la session
          $random = (sha1(random_bytes(20)));
          $session->set('random', $random);
          $session->set('orderid', $order->getId());
          $session->set('customer', $order->getCustomer());
          $session->set('firstname', $order->getCustomer()->getFirstname());
          $session->set('validitydate', $order->getTicket()->getValiditydate());
          $session->set('price', $order->getTicket()->getPrice());
          $session->set('ticket', $order->getTicket());
          $session->set('numberoftickets', $order->getNumberoftickets());
          $session->set('birthdate', $order->getTicket()->getTicketowner()->getBirthdate());
          $session->set('mail', $order->getCustomer()->getMail());
          $mail = $session->get('mail');


          //Redirection vers le récapitulatif
            return $this->redirectToRoute('p4_museum_recap');
        }

        return $this->render('P4MuseumBundle:Ticket:buy.html.twig', array(
          'form' => $form->createView(),
        ));
    }

    public function recapAction(Request $request)
        {
            $session = $request->getSession();

            $random = $session->get('random');
            $birthdate = $session->get('birthdate'); // Récupération de la session
            $id = $session->get('orderid');
            $em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('P4MuseumBundle:Orders')->find($id); 

            return $this->render('P4MuseumBundle:Ticket:recap.html.twig', array('orders' => $order,
                'random' => $random));
        }

    public function confirmAction(Request $request)
    {
        $session = $request->getSession();
        return $this->render('P4MuseumBundle:Ticket:confirm.html.twig');
    }
}