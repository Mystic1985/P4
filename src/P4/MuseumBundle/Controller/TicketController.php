<?php

// src/P4/MuseumBundle/Controller/TicketController.php

namespace P4\MuseumBundle\Controller;

use P4\MuseumBundle\Service\TicketService;
use P4\MuseumBundle\Service\StripeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;
use P4\MuseumBundle\Entity\Ticketowner;
use P4\MuseumBundle\Entity\Ticket;
use P4\MuseumBundle\Entity\Customer;
use P4\MuseumBundle\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use P4\MuseumBundle\Form\OrdersType;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketController extends Controller
{   
    public function indexAction(Request $request)
    {
    return $this->render('P4MuseumBundle:Ticket:index.html.twig');
    }
    
    public function checkoutAction(Request $request)
    {// Condition affichage -> Erreur 404 si id = null
        $session = $request->getSession();
        $id = $session->get('orderid');
     
        if(!$id) {
            throw new NotFoundHttpException();     
        }
        else {
            if ($request->isMethod('POST')){

                    $stripeService = $this->get('museum.stripe');
                    return $stripeService->checkoutOrders();
                }
            }

            return $this->render('P4MuseumBundle:Ticket:checkout.html.twig');
    }

    public function buyAction(Request $request)
    {
        // On crée un objet Orders
        $order = new Orders();
        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(OrdersType::class, $order);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
            {
                $ticketService = $this->get('museum.ticket');
                $ticketService->createTicket($order);
              //Redirection vers le récapitulatif
                return $this->redirectToRoute('p4_museum_recap');
            }

        else
        {
                $ticketService = $this->get('museum.ticket');
                $ticketService->removeOrders($order);
        }

        return $this->render('P4MuseumBundle:Ticket:buy.html.twig', array(
          'form' => $form->createView(),
        ));
    }

    public function recapAction(Request $request)
        {//Condition affichage : Erreur 404 si id = null
            $session = $request->getSession();
            $id = $session->get('orderid');

            if(!$id) {
                throw new NotFoundHttpException();     
            }
            else {
                $em = $this->getDoctrine()->getManager();
                $order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
                $numberoftickets = $em->getRepository('P4MuseumBundle:Ticket')->countByOrder($id);
                $listtickets = $order->getTickets();
                $totalprice = $order->getTotalprice();
                $session->set('totalprice', $totalprice);
            
            return $this->render('P4MuseumBundle:Ticket:recap.html.twig', array(
                'orders' => $order,
                'listtickets' => $listtickets,
                'numberoftickets' => $numberoftickets));
            }
        }

    public function deleteAction(Request $request)
    {
        $session = $request->getSession();

        $orderid = $session->get('orderid'); // id de la commande
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('P4MuseumBundle:Orders')->find($orderid); // récupération de la commande
        $listtickets = $order->getTickets(); // récupération de la liste des tickets liés à la commande
        foreach($listtickets as $ticket)
        {
            $ticketid = $ticket->getId();
        }
            $ticket = $em->getRepository('P4MuseumBundle:Ticket')->find($ticketid);
            $em->remove($ticket); // Suppression du billet
            $em->flush();

        return $this->redirectToRoute('p4_museum_recap');
    }
    public function confirmAction(Request $request)
    {
        $session = $request->getSession();
        return $this->render('P4MuseumBundle:Ticket:confirm.html.twig');
    }
}