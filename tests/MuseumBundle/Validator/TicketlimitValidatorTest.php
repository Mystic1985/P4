<?php

namespace Tests\MuseumBundle\Validator;

use P4\MuseumBundle\Validator\Ticketlimit;
use P4\MuseumBundle\Validator\TicketlimitValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContext;
use P4\MuseumBundle\Repository\TicketRepository;
use Doctrine\ORM\EntityManager;
/**
 * Class TicketlimitValidatorTest.
 */
class TicketlimitValidatorTest extends TestCase
{
    private $context;
    private $ticketlimitValidator;
    private $ticketlimit;
    private $repository;
    private $em;
    
    protected function setUp()
    {
        $this->context = $this->getMockBuilder(ExecutionContext::class)
            ->disableOriginalConstructor()
            ->setMethods(['addViolation'])
            ->getMock();

        $this->ticketlimit = $this->getMockBuilder(Ticketlimit::class)
                ->getMock();

        $this->ticketlimit->message = "Limite atteinte";

        $this->repository = $this->getMockBuilder(TicketRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['countByValiditydate'])
            ->getMock();

        $this->em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRepository'])
            ->getMock();

        $this->em->method('getRepository')->will($this->returnCallback(function($param) {
            return $this->repository;
        }));

        $this->ticketlimitValidator = new TicketlimitValidator($this->em);
        $this->ticketlimitValidator->initialize($this->context);
    }
    /**
     * Test de limites valides.
     */
    public function testValidationMoreThan1000Tickets()
    {   
        $this->repository->method('countByValiditydate')->willReturn(1001);
        $this->context->expects($this->once())
            ->method('addViolation');
        $this->ticketlimitValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-01-10'), $this->ticketlimit);
    }
    public function testValidationLessThan1000Tickets()
    {
        $this->repository->method('countByValiditydate')->willReturn(999);
        $this->context->expects($this->never())
            ->method('addViolation');
        $this->ticketlimitValidator->validate(\DateTime::createFromFormat('Y-m-d', '2019-01-10'), $this->ticketlimit);
    }
}