<?php
namespace P4\MuseumBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use P4\MuseumBundle\Validator\Ticketlimit;
use P4\MuseumBundle\Validator\Tuesdayticket;
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
    public function isValiditydateValid(ExecutionContextInterface $context)
    {
          $today = new \DateTime();
          $today = $today->format("Ymd");

          $validitydate = $this->getValiditydate();
          $validitydate = $validitydate->format("Ymd");

          if ($validitydate < $today)
          {
            $context
            ->buildViolation('La date de visite ne peut pas être antérieure à la date d\'aujourd\'hui.')
            ->atPath('validitydate')
            ->addViolation();
        }
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
        $limit = new \DateTime("14:00:00");
        $limit = $limit->format("H:i:s");
        if($validitydate == $today){
            if($limit < $time && $type == "Journée")
            {
                $context
                    ->buildViolation('Il n\'est pas possible de réserver un billet de type "Journée" après 14 heures.')
                    ->atPath('type')
                    ->addViolation();                 
            }
        }
    }
    /**
     * @Assert\Callback
     */
    public function isValiditydateTuesday(ExecutionContextInterface $context)
    {
        $validitydate = $this->getValiditydate();
        $validitydate = $validitydate->format("l");
        if($validitydate == "Tuesday")
        {
            $context
            ->buildViolation('Le musée est fermé le mardi. Merci de sélectionner une nouvelle date.')
            ->atPath('validitydate')
            ->addViolation(); 
        }
    }

    /**
     * @Assert\Callback
     */
    public function isValiditydateSunday(ExecutionContextInterface $context)
    {
        $validitydate = $this->getValiditydate();
        $validitydate = $validitydate->format("l");
        if($validitydate == "Sunday")
        {
            $context
            ->buildViolation('La réservation en ligne est indisponible pour le dimanche. Merci de sélectionner une nouvelle date.')
            ->atPath('validitydate')
            ->addViolation(); 
        }
    }
    
    /**
     * @Assert\Callback
     */
    public function isMuseumClosed(ExecutionContextInterface $context)
    {
        $validitydate = $this->getValiditydate();
        $validitydate = $validitydate->format("m-d");
        $fetedutravail = new \DateTime("2000-05-01");
        $toussaint = new \DateTime("2000-11-01");
        $christmas = new \DateTime("2000-12-25");
        $holidays = array(
            $fetedutravail->format("m-d"),
            $toussaint->format("m-d"),
            $christmas->format("m-d"));
        foreach($holidays as $holiday) {
            if($validitydate == $holiday)
            {
                $context
                ->buildViolation('Le musée est fermé à la date de visite choisie. Merci d\'en sélectionner une nouvelle.')
                ->atPath('validitydate')
                ->addViolation(); 
            }
        }
    }
    /**
     * @Assert\Callback
     */
    public function isValiditydateHoliday(ExecutionContextInterface $context)
    {
        // Récupération de la date de validité à partir du formulaire
        $validitydate = $this->getValiditydate(); 
        // Extraction de chaque élément de la date de validité
        $year = $validitydate->format("Y");
        $month = $validitydate->format("m");
        $day = $validitydate->format("d");
        $validitydateday = $validitydate->format("l");
        //Récupération du timestamp de la date de validité
        $validitydatetimestamp = mktime(0, 0, 0, $month, $day, $year);
        // Récupération de la date de Pâques
        $easterDate  = easter_date($year); 
          // Extraction de chaque élément de la date de Pâques
          $easterDay   = date('j', $easterDate);
          $easterMonth = date('n', $easterDate);
          $easterYear   = date('Y', $easterDate);
          //Création d'un tableau répertoriant les timestamp des jours fériés variables
        $holidays = array(
                mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
                mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
                mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
                mktime(0, 0, 0, 8,  15, $year),  // Assomption
                mktime(0, 0, 0, 11, 11, $year),  // Armistice
                //Jours fériés variables
                mktime(0, 0, 0, $easterMonth, $easterDay, $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear));
        
        foreach($holidays as $holiday) {
            if($validitydatetimestamp == $holiday){
                /*if($validitydateday == "Sunday"){
                        $context
                        ->buildViolation('La réservation en ligne est indisponible pour les dimanches. Merci de sélectionner une nouvelle date.')
                        ->atPath('validitydate')
                        ->addViolation(); 
                }
                else {*/
                        $context
                        ->buildViolation('La réservation en ligne est indisponible pour les jours fériés. Merci de sélectionner une nouvelle date de visite.')
                        ->atPath('validitydate')
                        ->addViolation(); 
                // }        
            }
        }
    }

}
