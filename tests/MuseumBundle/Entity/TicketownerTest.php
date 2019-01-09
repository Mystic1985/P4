<?php

namespace Tests\MuseumBundle\Entity;

use P4\MuseumBundle\Entity\Ticketowner;
use PHPUnit\Framework\TestCase;

class TicketownerTest extends TestCase
{
    public function testgetFirstnameTicketowner()
    {
        $ticketowner = new Ticketowner();
        $ticketowner->setFirstname('Arnaud');

        $this->assertSame('Arnaud', $ticketowner->getFirstname());
    }
}