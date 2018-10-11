<?php
// src/P4/MuseumBundle/Validator/Ticketlimit.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Ticketlimit extends Constraint
{
  	public $message = "Le quantité de billets disponibles à la réservation pour ce jour a été atteinte. Merci de choisir une nouvelle date de visite.";

  	public function validatedBy()
  	{
  		return 'p4_museum_ticketlimit'; // On fait appel à l'alias du service
  	}
}