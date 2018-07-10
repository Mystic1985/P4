<?php

// src/P4/MuseumBundle/Controller/TicketController.php

namespace P4\MuseumBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexAction()
    {

    $listTickets = $this->getDoctrine()->getManager()
      ->getRepository('P4MuseumBundle:Ticket')
      ->getTickets();

    return $this->render('P4MuseumBundle:Ticket:index.html.twig', array(
        'listTickets' => $listTickets,));

    }

    public function buyAction(Request $request)
    {
    // On crée un objet Orders
    $order = new Orders();

    // On crée le FormBuilder grâce au service form factory
    $form = $this->createForm(OrdersType::class, $order);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($order);
      $em->flush();
      return $this->redirectToRoute('p4_museum_info');
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

    public function infoAction(Request $request)
    {
    // On crée un objet Ticketowner
    $customer = new Customer();

    // On crée le FormBuilder grâce au service form factory
    $form = $this->createForm(CustomerType::class, $customer);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($customer);
      $em->flush();
      return $this->redirectToRoute('p4_museum_price');
    }
    return $this->render('P4MuseumBundle:Ticket:infosclient.html.twig', array(
    'form' => $form->createView(),
    ));

    }
    public function addAction(Request $request)
    {
    // Création de l'entité Advert
    $ticket = new Ticket();
    $ticket->setPrice('10');
    $ticket->setValiditydate(date('11/10/2018'));
    $ticket->setType("Demi-journée");

    // Création de l'entité Image
    $ticketowner = new ticketowner();
    $ticketowner->setFirstname('Nono');
    $ticketowner->setName('Bis');
    $ticketowner->setCountry('France');

    // On lie l'image à l'annonce
    $ticket->setTicketowner($ticketowner);

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($ticket);

    // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
    // on devrait persister à la main l'entité $image
    // $em->persist($image);

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('P4MuseumBundle:Ticket:index.html.twig', array(
      'ticket' => $ticket,
      'ticketowner' => $ticketowner,
    ));
  }
}