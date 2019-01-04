<?php
// src/P4/MuseumBundle/Validator/Mailvalid.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Mailvalid extends Constraint
{
  	public $message = "Veuillez rentrer une adresse mail valide.";

  	public function validatedBy()
  	{
  		return 'p4_museum_mailvalid'; // On fait appel à l'alias du service
  	}
}