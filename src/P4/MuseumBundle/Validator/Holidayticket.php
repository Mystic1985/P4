<?php
//src/P4/MuseumBundle/Validator\Holidayticket

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Holidayticket extends Constraint
{
	public $message = "La réservation en ligne est indisponible pour les jours fériés. Merci de sélectionner une nouvelle date de visite.";

	public function validatedBy()
	{
		return 'p4_museum_holidayticket';
	}
}