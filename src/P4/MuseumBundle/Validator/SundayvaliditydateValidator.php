<?php
// src/P4/MuseumBundle/Validator/SundayvaliditydateValidator.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

class SundayvaliditydateValidator extends ConstraintValidator
{
    const SUNDAY = "Sunday";
    
	public function validate($value, Constraint $constraint)
	{
        if($value->format("l") == self::SUNDAY)
        {
        	$this->context->addViolation($constraint->message);
        }
	}
}