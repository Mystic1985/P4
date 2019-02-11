<?php
// src/P4/MuseumBundle/Validator/MailvalidValidator.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

class MailvalidValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{ 
		if (!preg_match('#^[a-z0-9.-_]+@[a-z0-9.-_]{2,}\.[a-z]{2,4}$#', $value)) {
			$this->context->addViolation($constraint->message);
		}
	}  
}