<?php
// src/P4/MuseumBundle/Validator/TicketlimitValidator.php

namespace P4\MuseumBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use P4\MuseumBundle\Controller\TicketController;
use Symfony\Component\HttpFoundation\Session\Session;

class TicketlimitValidator extends ConstraintValidator
{
	private $requestStack;
	private $em;

	// Les arguments déclarés dans la définition du service arrivent au constructeur
	// On doit les enregistrer dans l'objet pour pouvoir s'en resservir dans la méthode validate()
	public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
	{
	  $this->requestStack = $requestStack;
	  $this->em           = $em;
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