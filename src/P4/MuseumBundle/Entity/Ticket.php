<?php
namespace P4\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use P4\MuseumBundle\Validator\Ticketlimit;
use P4\MuseumBundle\Validator\Tuesdayvaliditydate;
use P4\MuseumBundle\Validator\Sundayvaliditydate;
use P4\MuseumBundle\Validator\IsClosed;
use P4\MuseumBundle\Validator\Holidayticket;
/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="P4\MuseumBundle\Repository\TicketRepository")
 */
class Ticket
{
    CONST HALF_DAY = 1;
    CONST FULL_DAY = 2;
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
     * @ORM\OneToOne(targetEntity="P4\MuseumBundle\Entity\Ticketowner", cascade={"persist", "remove"})
     */     
    private $ticketowner;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validitydate", type="date")
     * @Ticketlimit()
     * @Sundayvaliditydate()
     * @IsClosed()
     * @Holidayticket()
     * @Tuesdayvaliditydate()
     */
    private $validitydate;
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    /**
     * @ORM\Column(name="reduction", type="boolean")
     */
    private $reduction;

    /**
     * @ORM\ManyToOne(targetEntity="P4\MuseumBundle\Entity\Orders", inversedBy="tickets")
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
        $this->orders = $order;
        return $this;
    }
    /**
     * Get order
     *
     * @return \P4\MuseumBundle\Entity\Orders
     */
    public function getOrders()
    {
        return $this->orders;
    }
    /**
     * Set reduction
     *
     * @param boolean $reduction
     *
     * @return Ticket
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;
        return $this;
    }
    /**
     * Get reduction
     *
     * @return boolean
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    public function getTicketprice()
    {
        $age = $this->ticketowner->getAge();
        
        if($age >= 0 && $age < 4){
            $ticketprice = 0;
        }
        else {
            if($this->reduction == 0){
                if($age >= 4 && $age < 12)
                    {
                        $ticketprice = 8;
                    }
                else if($age >= 12 && $age < 60)
                    {
                        $ticketprice = 16;
                    }
                else if($age >= 60)
                    {
                        $ticketprice = 12;
                    }
            }
            else {
                $ticketprice = 10;
            }
        }  

        return $ticketprice;
    }

    /**
     * @Assert\Callback
     */
    public function isTypeValid(ExecutionContextInterface $context)
    {
        //Récupération du type de billet
        $type = $this->getType();
        $validitydate = $this->getValiditydate();
        $validitydate = $validitydate->format("d/m/Y");
        $today = new \DateTime();
        $today = $today->format("d/m/Y");
        //Création d'un objet DateTime et formatage de la date pour extraire l'heure
        $time = new \DateTime();
        $time = $time->format("H:i:s");
        //Définition de l'heure limite
        $limit = new \DateTime("10:00:00");
        $limit = $limit->format("H:i:s");
        if($validitydate == $today){
            if($limit < $time && $type == self::FULL_DAY)
            {
                $context
                    ->buildViolation('Il est impossible de réserver un billet de type "Journée" après 14 heures.')
                    ->atPath('type')
                    ->addViolation();                 
            }
        }
    }

}
