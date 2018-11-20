<?php
namespace P4\MuseumBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use P4\MuseumBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    public function __construct(SessionInterface $session, ObjectManager $manager)
    {
        $this->session = $session;
        $this->manager = $manager;
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
        $random = (sha1(random_bytes(20)));
        $this->session->set('random', $random);
        $this->session->set('orderid', $order->getId());

        return $order;
    }
}