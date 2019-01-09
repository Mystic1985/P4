<?php
namespace Tests\MuseumBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTestAbstract.
 */
abstract class ValidatorTestAbstract extends TestCase
{
    /**
     * Retourne une instance du validateur à tester.
     *
     * @return ConstraintValidator
     */
    abstract protected function getValidatorInstance();

    /**
     * Initialise le validateur.
     *
     * @param string|null $expectedMessage le message de violation attendu (null si on attend que la valeur soit
     *                                     validée)
     *
     * @return ConstraintValidator
     */
    protected function initValidator($expectedMessage = null)
    {
        $context = $this->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();

        /*$context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['buildViolation'])
            ->getMock();*/

        if ($expectedMessage) {
            $context->expects($this->once())->method('addViolation');

            $context->expects($this->once())
                ->method('buildViolation')
                ->with($this->equalTo($expectedMessage))
                ->will($this->returnValue($builder));
        } else {
            $context->expects($this->never())->method('buildViolation');
        }

        $validator = $this->getValidatorInstance();
        /* @var ExecutionContext $context */
        $validator->initialize($context);

        return $validator;
    }
}