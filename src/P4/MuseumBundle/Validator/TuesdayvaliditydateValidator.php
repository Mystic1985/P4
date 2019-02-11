<?php
// src/P4/MuseumBundle/Validator/TuesdayvaliditydateValidator.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

class TuesdayvaliditydateValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{ 
        $value = $value->format("l");
        if($value == "Tuesday")
        {
        	$this->context->addViolation($constraint->message);
        }
	}  
}