<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\IsClosed;
use P4\MuseumBundle\Validator\IsClosedValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;

class IsClosedValidatorTest extends TestCase
{
    private $context;
    private $isClosedValidator;
    private $isClosed;
    
    protected function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();
        $this->isClosed = $this->getMockBuilder(isClosed::class)
            ->getMock();
        $this->isClosed->message = "musée fermé";

        $this->isClosedValidator = new IsClosedValidator();
        $this->isClosedValidator->initialize($this->context);
    }

    public function testValidationOk()
    {
        $this->context->expects($this->never())
            ->method('addViolation');
        $this->isClosedValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-12-14'), $this->isClosed);
    }
    public function testValidationKo()
    {
        $this->context->expects($this->once())
            ->method('addViolation')
            ->with($this->isClosed->message);
        ;
        $this->isClosedValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-12-25'), $this->isClosed);
    }
}