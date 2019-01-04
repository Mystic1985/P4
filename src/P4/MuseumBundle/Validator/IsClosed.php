<?php
//src/P4/MuseumBundle/Validator\IsClosed.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsClosed extends Constraint
{
	public $message = "Le musée est fermé à la date de visite choisie. Merci d'en sélectionner une nouvelle.";

	public function validatedBy()
	{
		return 'p4_museum_isclosed';
	}
}