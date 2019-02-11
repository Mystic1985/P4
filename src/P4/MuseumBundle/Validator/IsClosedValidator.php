<?php
// src/P4/MuseumBundle/Validator/IsClosedValidator.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

class IsClosedValidator extends ConstraintValidator
{

	public function validate($value, Constraint $constraint)
	{ 
        $value = $value->format("md");

        $fetedutravail = new \DateTime("2000-05-01");
        $toussaint = new \DateTime("2000-11-01");
        $christmas = new \DateTime("2000-12-25");

        $holidays = array(
            $fetedutravail->format("md"),
            $toussaint->format("md"),
            $christmas->format("md"));

        foreach($holidays as $holiday) {
            if($value == $holiday)
            {
            	$this->context->addViolation($constraint->message);
            }
        }
	}  
}