<?php

namespace P4\MuseumBundle\Repository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends \Doctrine\ORM\EntityRepository
{
	public function getTickets()
  	{
    $qb = $this->createQueryBuilder('t');
    // On fait une jointure avec l'entité Category avec pour alias « c »
    $qb
      ->innerJoin('t.ticketowner', 'ti')
      ->addSelect('ti');
    return $qb
      ->getQuery()
      ->getResult()
      ;
  }
}
