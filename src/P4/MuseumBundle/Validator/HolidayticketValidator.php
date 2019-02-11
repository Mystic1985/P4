<?php
// src/P4/MuseumBundle/Validator/HolidayticketValidator.php

namespace P4\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Session\Session;

class HolidayticketValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{ 
        // Extraction de chaque élément de la date de validité
        $year = $value->format("Y");
        $month = $value->format("m");
        $day = $value->format("d");
        $valueday = $value->format("l");
        //Récupération du timestamp de la date de validité
        $valuetimestamp = mktime(0, 0, 0, $month, $day, $year);
        // Récupération de la date de Pâques
        $easterDate  = easter_date($year); 
          // Extraction de chaque élément de la date de Pâques
          $easterDay   = date('j', $easterDate);
          $easterMonth = date('n', $easterDate);
          $easterYear   = date('Y', $easterDate);
          //Création d'un tableau répertoriant les timestamp des jours fériés variables
        $holidays = array(
                mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
                mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
                mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
                mktime(0, 0, 0, 8,  15, $year),  // Assomption
                mktime(0, 0, 0, 11, 11, $year),  // Armistice
                //Jours fériés variables
                mktime(0, 0, 0, $easterMonth, $easterDay, $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
                mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear));
        
        foreach($holidays as $holiday) {
            if($valuetimestamp == $holiday){
				$this->context->addViolation($constraint->message);    
            }
        }
	}  
}