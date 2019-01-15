<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\Sundayvaliditydate;
use P4\MuseumBundle\Validator\SundayvaliditydateValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;
/**
 * Class TicketlimitValidatorTest.
 */
class SundayvaliditydateValidatorTest extends TestCase
{
    private $context;
    private $sundayValidator;
    private $sundayValidityDate;
    
    protected function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();
        $this->sundayValidityDate = $this->getMockBuilder(Sundayvaliditydate::class)
            //->setMethods(['getMessage'])
            ->getMock();
        $this->sundayValidityDate->message = "message mocked";
        /*$this->sundayValidityDate
            ->method('getMessage')
            ->willReturn('message')
        ;*/
        //$this->sundayValidityDate = new Sundayvaliditydate();
        $this->sundayValidator = new SundayvaliditydateValidator();
        $this->sundayValidator->initialize($this->context);
    }
    /**
     * Test de mails valides.
     */
    public function testValidationOk()
    {
        $this->context->expects($this->never())
            ->method('addViolation');
        $this->sundayValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-01-10'), $this->sundayValidityDate);
    }
    public function testValidationKo()
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->sundayValidityDate->message);
        ;
        $this->sundayValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-01-13'), $this->sundayValidityDate);
    }
}