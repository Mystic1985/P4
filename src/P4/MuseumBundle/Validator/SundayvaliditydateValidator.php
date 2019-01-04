<?php
// src/P4/MuseumBundle/Validator/SundayvaliditydateValidator.php

namespace P4\MuseumBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use P4\MuseumBundle\Controller\TicketController;
use Symfony\Component\HttpFoundation\Session\Session;

class SundayvaliditydateValidator extends ConstraintValidator
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
        $value = $value->format("l");
        if($value == "Sunday")
        {
        	$this->context->addViolation($constraint->message);
        }
	}  
}