<?php
//src/P4/MuseumBundle/Validator\Tuesdayvaliditydate

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Tuesdayvaliditydate extends Constraint
{
	public $message = "Le musée est fermé le mardi. Merci de sélectionner une autre date.";

	public function validatedBy()
	{
		return 'p4_museum_tuesdayvaliditydate';
	}
}