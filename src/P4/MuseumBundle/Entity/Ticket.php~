<?php

namespace P4\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="P4\MuseumBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="P4\MuseumBundle\Entity\Ticketowner", cascade={"persist"})
     */     
    private $ticketowner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validitydate", type="date")
     */
    private $validitydate;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="P4\MuseumBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orders;

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
     * Set price
     *
     * @param integer $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set ticketowner
     *
     * @param string $ticketowner
     *
     * @return Ticket
     */
    public function setTicketowner($ticketowner)
    {
        $this->ticketowner = $ticketowner;

        return $this;
    }

    /**
     * Get ticketowner
     *
     * @return string
     */
    public function getTicketowner()
    {
        return $this->ticketowner;
    }

    /**
     * Set validitydate
     *
     * @param \DateTime $validitydate
     *
     * @return Ticket
     */
    public function setValiditydate($validitydate)
    {
        $this->validitydate = $validitydate;

        return $this;
    }

    /**
     * Get validitydate
     *
     * @return \DateTime
     */
    public function getValiditydate()
    {
        return $this->validitydate;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set order
     *
     * @param \P4\MuseumBundle\Entity\Orders $order
     *
     * @return Ticket
     */
    public function setOrders(\P4\MuseumBundle\Entity\Orders $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \P4\MuseumBundle\Entity\Orders
     */
    public function getOrders()
    {
        return $this->order;
    }
}
