<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\Mailvalid;
use P4\MuseumBundle\Validator\MailvalidValidator;

/**
 * Class TicketlimitValidatorTest.
 */
class MailvalidValidatorTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new MailvalidValidator();
    }
     /**
     * Test de mails valides.
     */
    public function testValidationOk()
    {
        $mailConstraint = new Mailvalid();
        $mailValidator = $this->initValidator();

        $mailValidator->validate('arnaud@moi', $mailConstraint);
        /*$phoneNumberValidator->validate('01-78-45-78-89', $phoneNumberConstraint);
        $phoneNumberValidator->validate('0178457889', $phoneNumberConstraint);
        $phoneNumberValidator->validate('+33 6 01 02 03 04', $phoneNumberConstraint);
        $phoneNumberValidator->validate('+33 6-01-02-03-04', $phoneNumberConstraint);
        $phoneNumberValidator->validate('+33601020304', $phoneNumberConstraint);
        $phoneNumberValidator->validate('0033 6-01-02-03-04', $phoneNumberConstraint);
        $phoneNumberValidator->validate('0033 6-01-02-03-04', $phoneNumberConstraint);*/
    }

    public function testValidationKo()
    {
        $mailConstraint = new Mailvalid();
        $mailValidator = $this->initValidator($mailConstraint->message);

        $mailValidator->validate('esdgfdsgdf', $mailConstraint);
        $mailValidator->validate('178457889', $mailConstraint);

        /*$phoneNumberValidator = $this->initValidator($phoneNumberConstraint->message);
        $phoneNumberValidator->validate('33 6 01 02 03 04', $phoneNumberConstraint);

        $phoneNumberValidator = $this->initValidator($phoneNumberConstraint->message);
        $phoneNumberValidator->validate('06 01 02 03 04 92', $phoneNumberConstraint);

        $phoneNumberValidator = $this->initValidator($phoneNumberConstraint->message);
        $phoneNumberValidator->validate('01_54_78_33_24', $phoneNumberConstraint);*/
    }
}	
