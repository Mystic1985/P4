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
     * @ORM\OneToOne(targetEntity="P4\MuseumBundle\Entity\Customer", cascade={"persist", "remove"})
     * @Assert\Valid()
     */ 
    private $customer;
    /**
     * @ORM\OneToMany(targetEntity="P4\MuseumBundle\Entity\Ticket", mappedBy="orders", cascade={"persist", "remove"})
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
     * @ORM\Column(name="code", type="string")
     */
    private $code;
    /**
     * @ORM\Column(name="paymentstatus", type="boolean", nullable=true)
     */
    private $paymentstatus;
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
        $this->code = sha1(random_bytes(20));
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

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Orders
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set paymentstatus
     *
     * @param boolean $paymentstatus
     *
     * @return Orders
     */
    public function setPaymentstatus($paymentstatus)
    {
        $this->paymentstatus = $paymentstatus;

        return $this;
    }

    /**
     * Get paymentstatus
     *
     * @return boolean
     */
    public function getPaymentstatus()
    {
        return $this->paymentstatus;
    }
}
