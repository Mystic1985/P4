<?php
namespace P4\MuseumBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use P4\MuseumBundle\Validator\Ticketlimit;
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
     * @Assert\Valid()
     */ 
    private $customer;
    /**
     * @ORM\OneToMany(targetEntity="P4\MuseumBundle\Entity\Ticket", mappedBy="orders", cascade={"persist"})
     * @Assert\Valid()
     */
    private $tickets;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderdate", type="date")
     */
    private $orderdate;
    /**
     * @ORM\Column(name="numberoftickets", type="integer")
     */
    private $numberoftickets;
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
        $this->orderdate = new \DateTime();
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
        $this->tickets->add($ticket);

        $ticket->setOrders($this);

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
    
    /**
     * Set numberoftickets
     *
     * @param integer $numberoftickets
     *
     * @return Orders
     */
    public function setNumberoftickets($numberoftickets)
    {
        $this->numberoftickets = $numberoftickets;
        return $this;
    }
    /**
     * Get numberoftickets
     *
     * @return integer
     */
    public function getNumberoftickets()
    {
        return $this->numberoftickets;
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    public function getTotalprice()
    {
        $totalprice = 0;
        $ticketlist = $this->getTickets();
        foreach ($ticketlist as $ticket) {
            $totalprice += $ticket->getTicketprice();
        }

        return $totalprice;

    }
}
