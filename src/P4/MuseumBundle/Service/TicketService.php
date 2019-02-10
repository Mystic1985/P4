<?php
namespace P4\MuseumBundle\Service;


use Doctrine\Common\Persistence\ObjectManager;
use P4\MuseumBundle\Entity\Orders;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class TicketService
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManager
     */
    private $manager;
    private $router;

    public function __construct(SessionInterface $session, EntityManager $manager)
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
    public function createTicket(Orders $order)
    {
        $em = $this->manager;
        $em->persist($order);
        $em->flush();
        // Flush des informations
        // Définition des variables de la session
        $this->session->set('orderid', $order->getId());
        $this->session->set('mail', $order->getCustomer()->getMail());

        return $order;
    }

    public function removeOrders(Orders $order)
    {
        $id = $this->session->get('orderid');
        if(isset($id))
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