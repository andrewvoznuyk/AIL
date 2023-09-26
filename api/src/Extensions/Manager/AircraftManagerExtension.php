<?php

namespace App\Extensions\Manager;

use App\Entity\Aircraft;
use App\Entity\CompanyFlights;
use App\Entity\Flight;
use App\Entity\User;
use App\Extensions\Owner\AbstractOwnerAccessExtension;
use Doctrine\ORM\QueryBuilder;

class AircraftManagerExtension extends AbstractManagerAccessExtension
{

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return Aircraft::class;
    }

    /**
     * @return array
     */
    public function getAffectedMethods(): array
    {
        return [
            self::GET
        ];
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
            ->innerJoin($rootAlias.".company", "comp")
            ->innerJoin("comp.managers", "us")
            ->andWhere('us = :user')
            ->setParameter('user', $binaryId)
        ;
    }
}