<?php

// src/P4/MuseumBundle/Controller/TicketController.php

namespace P4\MuseumBundle\Controller;

use P4\MuseumBundle\Service\TicketService;
use P4\MuseumBundle\Service\StripeService;
use P4\MuseumBundle\Service\MailService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
    {
        // Condition affichage -> Erreur 404 si id = null ou totalprice = 0
        $session = $request->getSession();
        $id = $session->get('orderid');
        $totalprice = $session->get('totalprice');

        if(!$id || $totalprice == 0) {
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

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $ticketService = $this->get('museum.ticket');
                $ticketService->createTicket($order);
              //Redirection vers le récapitulatif
                return $this->redirectToRoute('p4_museum_recap');
        }

        else {
                $ticketService = $this->get('museum.ticket');
                $ticketService->removeOrders($order);
        }

        return $this->render('P4MuseumBundle:Ticket:buy.html.twig', array(
          'form' => $form->createView(),
        ));
    }

    public function recapAction(Request $request)
    {
        //Condition affichage : Erreur 404 si id = null
        $session = $request->getSession();
        $id = $session->get('orderid');

        if(!$id) {
            throw new NotFoundHttpException();     
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
            // Nombre de tickets par commande
            $numberoftickets = $em->getRepository('P4MuseumBundle:Ticket')->countByOrder($id);
            $session->set('numberoftickets', $numberoftickets);
            // Liste des tickets de la commande
            $listtickets = $order->getTickets();
            // Prix total
            $totalprice = $order->getTotalprice();
            $session->set('totalprice', $totalprice);

            if($numberoftickets > 0) {
                return $this->render('P4MuseumBundle:Ticket:recap.html.twig', array(
                    'orders' => $order,
                    'listtickets' => $listtickets,
                    'numberoftickets' => $numberoftickets));
            }
            else {
                throw new NotFoundHttpException();   
            }
        }
    }

    public function deleteAction(Request $request) // Suppression d'un billet dans la récap
    {
        $session = $request->getSession();

        $id = $session->get('orderid'); // id de la commande
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('P4MuseumBundle:Orders')->find($id); // récupération de la commande
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

    public function confirmAction(Request $request) // Page de confirmation
    {
        $session = $request->getSession();
        $totalprice = $session->get('totalprice');
        $id = $session->get('orderid');
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('P4MuseumBundle:Orders')->find($id); // récupération de la commande
        $numberoftickets = $em->getRepository('P4MuseumBundle:Ticket')->countByOrder($id);

        if($numberoftickets == 0){
            throw new NotFoundHttpException();
            $session->clear();
        }

        else {
            if($totalprice == 0)
            {
                // Envoi du mail
                $this->get('museum.mail')->sendConfirmMessage($order);

                $order->setPaymentstatus(1);
                $em->persist($order);
                $em->flush();

                $session->clear();// Suppression de la session
            }
            $session->clear();
            return $this->render('P4MuseumBundle:Ticket:confirm.html.twig');
        }
    }
}