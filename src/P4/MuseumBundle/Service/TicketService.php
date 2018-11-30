<?php
namespace P4\MuseumBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use P4\MuseumBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use P4\MuseumBundle\Repository\OrdersRepository;

class TicketService
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var ObjectManager
     */
    private $manager;

    private $repository;


    public function __construct(SessionInterface $session, ObjectManager $manager, OrdersRepository $repository)
    {
        $this->session = $session;
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * Save an order in database
     *
     * @param Orders $order
     * @return Orders
     */
    public function createTicket(Orders $order): Orders
    {
        $em = $this->manager;
        $em->persist($order);
        $em->flush();
        // Flush des informations
        //Récupération des variables de la session
        $this->session->set('orderid', $order->getId());

        return $order;
    }

    public function removeOrder(Orders $order)
    {
        $id = $this->session->get('orderid');
        if($id != null)
            {
               $em = $this->manager;
               $order = $em->getRepository('P4MuseumBundle:Orders')->find($id);
               $ordercount = $em->getRepository('P4MuseumBundle:Orders')->countOrdersId($order);

                if($ordercount != null) {
                    $em->remove($order); // Suppression de la commande
                    $em->flush();
                    $this->session->clear(); // Suppression des variables de la session 
                }
            }
    }
}