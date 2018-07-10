<?php

namespace P4\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="P4\MuseumBundle\Repository\OrdersRepository")
 */
class Orders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="P4\MuseumBundle\Entity\Customer", cascade={"persist"})
     */ 
    private $customer;

    /**
     * @var string
     * @ORM\OneToMany(targetEntity="P4\MuseumBundle\Entity\Ticket", mappedBy="orders", cascade={"persist"})
     */
    private $tickets;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderdate", type="datetime")
     * @Assert\DateTime()
     */
    private $orderdate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer
     *
     * @param string $customer
     *
     * @return Orders
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set tickets
     *
     * @param string $tickets
     *
     * @return Orders
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;

        return $this;
    }

    /**
     * Get tickets
     *
     * @return string
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set orderdate
     *
     * @param \DateTime $orderdate
     *
     * @return Orders
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderdate = new \Datetime();
    }

    /**
     * Add ticket
     *
     * @param \P4\MuseumBundle\Entity\Ticket $ticket
     *
     * @return Orders
     */
    public function addTicket(\P4\MuseumBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \P4\MuseumBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\P4\MuseumBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }
}
