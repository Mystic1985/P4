<?php
// src/P4/MuseumBundle/Validator/TicketlimitValidator.php

namespace P4\MuseumBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

class TicketlimitValidator extends ConstraintValidator
{
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
	  $this->em = $em;
	}

	public function validate($value, Constraint $constraint)
	{ 
     	//Appel de la méthode permettant de compter le nombre de billets vendus pour une date
    	$numberofticket = $this->em
    						   ->getRepository('P4MuseumBundle:Ticket')
    						   ->countByValiditydate($value);
    				
    	if($numberofticket > 1000){
	    	$this->context->addViolation($constraint->message);
		}
	}  
}