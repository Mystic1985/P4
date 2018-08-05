<?php

// src/P4/MuseumBundle/Controller/TicketController.php

namespace P4\MuseumBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use P4\MuseumBundle\Entity\Ticketowner;
use P4\MuseumBundle\Entity\Ticket;
use P4\MuseumBundle\Entity\Customer;
use P4\MuseumBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\MuseumBundle\Form\TicketownerType;
use P4\MuseumBundle\Form\TicketType;
use P4\MuseumBundle\Form\CustomerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use P4\MuseumBundle\Form\OrdersType;

class TicketController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $orderdate = $session->get('orderdate');

        $em = $this->getDoctrine()->getManager();
        $orderlist = $em->getRepository('P4MuseumBundle:Orders')->getnumberofTicketsPerDay($session->get('orderdate'));
    return $this->render('P4MuseumBundle:Ticket:index.html.twig', array(
        'orderlist' => $orderlist));

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
          $em->flush(); // Flush des informations
          //Récupération des variables de la session
          $orderid = $order->getId();
          $orderdate = $order->getOrderdate();
          $session->set('orderdate', $order->getOrderdate());
          $session->set('orderid', $order->getId());
          $session->set('customer', $order->getCustomer());
          $session->set('ticket', $order->getTicket());

            return $this->redirectToRoute('p4_museum_homepage');
    }

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('P4MuseumBundle:Ticket:buy.html.twig', array(
      'form' => $form->createView(),
    ));
    }

    public function priceAction()
    {
    	return $this->render('P4MuseumBundle:Ticket:price.html.twig');
    }

    public function recapAction(Request $request)
    {
        $session = $request->getSession(); // Récupération de la session
        $id = $session->get('orderid');

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('P4MuseumBundle:Orders')->find($id); 

        return $this->render('P4MuseumBundle:Ticket:recap.html.twig', array('orders' => $order));
    }

}