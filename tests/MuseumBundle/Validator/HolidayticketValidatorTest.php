<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\Holidayticket;
use P4\MuseumBundle\Validator\HolidayticketValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;
/**
 * Class HolidayticketValidatorTest.
 */
class HolidayticketValidatorTest extends TestCase
{
    private $context;
    private $holidayValidator;
    private $holidayticket;
    
    protected function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();
        $this->holidayticket = $this->getMockBuilder(Holidayticket::class)
            ->getMock();
        $this->holidayticket->message = "message mocked";
        $this->holidayValidator = new HolidayticketValidator();
        $this->holidayValidator->initialize($this->context);
    }
    /**
     * Test de dates valides.
     */
    public function testDatesValides()
    {
        $this->context->expects($this->never())
            ->method('addViolation');
        $this->holidayValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-01-10'), $this->holidayticket);
    }
    public function testJoursFeries()
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->holidayticket->message);
        ;
        $this->holidayValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-11-11'), $this->holidayticket);
    }
}