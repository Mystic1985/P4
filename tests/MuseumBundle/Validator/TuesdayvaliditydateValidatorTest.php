<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\Tuesdayvaliditydate;
use P4\MuseumBundle\Validator\TuesdayvaliditydateValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;
/**
 * Class TuesdayvaliditydateValidatorTest.
 */
class TuesdayvaliditydateValidatorTest extends TestCase
{
    private $context;
    private $tuesdayValidator;
    private $tuesdayValidityDate;
    
    protected function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();
        $this->tuesdayValidityDate = $this->getMockBuilder(Tuesdayvaliditydate::class)
            ->getMock();
        $this->tuesdayValidityDate->message = "Musée fermé le mardi";
        $this->tuesdayValidator = new TuesdayvaliditydateValidator();
        $this->tuesdayValidator->initialize($this->context);
    }
    /**
     * Test de dates valides.
     */
    public function testValidationOk()
    {
        try {
        $this->context->expects($this->never())
            ->method('addViolation');
        $this->tuesdayValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-02-13'), $this->tuesdayValidityDate);
        } catch(\Exception $e) {
            echo 'test refusé';
        }
    }
    public function testValidationKo()
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->tuesdayValidityDate->message);
        ;
        $this->tuesdayValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-02-12'), $this->tuesdayValidityDate);
    }
}