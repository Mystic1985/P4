<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\Mailvalid;
use P4\MuseumBundle\Validator\MailvalidValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class TicketlimitValidatorTest.
 */
class MailvalidValidatorTest extends TestCase
{
    private $context;
    private $mailValidator;
    private $mailConstraint;

    protected function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();

        $this->mailConstraint = new Mailvalid();
        $this->mailValidator = new MailvalidValidator();
        $this->mailValidator->initialize($this->context);
    }

    /**
     * Test de mails valides.
     */
    public function testValidationOk()
    {

        $this->context->expects($this->never())
            ->method('addViolation');

        $this->mailValidator->validate('arnaud@test.dev', $this->mailConstraint);
    }

    public function testValidationWithoutArobassKo()
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->mailConstraint->message)
        ;

        $this->mailValidator->validate('esdgfdsgdf', $this->mailConstraint);
    }

    public function testValidationWithoutPointKo()
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->mailConstraint->message)
        ;

        $this->mailValidator->validate('esdgfdsgdf@local', $this->mailConstraint);
    }
}	
