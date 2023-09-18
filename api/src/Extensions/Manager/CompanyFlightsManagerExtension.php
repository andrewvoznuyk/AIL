<?php

namespace App\Extensions\Manager;

use App\Entity\CompanyFlights;
use App\Entity\User;
use App\Extensions\Owner\AbstractOwnerAccessExtension;
use Doctrine\ORM\QueryBuilder;

class CompanyFlightsManagerExtension extends AbstractManagerAccessExtension
{

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return CompanyFlights::class;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return void
     */
    public function buildQuery(QueryBuilder $queryBuilder): void
    {
        $rootAlias = $queryBuilder->getRootAliases()[self::FIRST_ELEMENT_ARRAY];

        /** @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();
        $binaryId = $currentUser->getId()->toBinary();

        $queryBuilder
            ->innerJoin($rootAlias.".company", "c")
            ->leftJoin("c.managers", "u")
            ->andWhere('u = :user')
            ->setParameter('user', $binaryId);

        //dd($queryBuilder->getQuery()->getSQL());
    }
}