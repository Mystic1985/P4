<?php

namespace P4\MuseumBundle\Repository;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends \Doctrine\ORM\EntityRepository
{
	public function getNumberofticketsPerDay($orderdate)
	{
		$qb = $this->createQueryBuilder('o');
		$qb
			->where('o.orderdate = :orderdate')
			->setParameter('orderdate', $orderdate);

		$results = $qb
			->getQuery()
			->getResult();
		return $results;

	}
}
