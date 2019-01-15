<?php
//src/P4/MuseumBundle/Validator/Sundayvaliditydate

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Sundayvaliditydate extends Constraint
{
	public $message = "La réservation en ligne est indisponible pour le dimanche. Merci de sélectionner une autre date.";

	public function validatedBy()
	{
		return 'p4_museum_sundayvaliditydate';
	}
}