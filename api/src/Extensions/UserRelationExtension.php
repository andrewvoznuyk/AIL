<?php

namespace App\Extensions;

use Doctrine\ORM\QueryBuilder;

/**
 * @deprecated use User folded extensions instead.
 */
abstract class UserRelationExtension extends AbstractCurrentUserExtension
{

    /**
     * @param QueryBuilder $queryBuilder
     * @return void
     */
    public function buildQuery(QueryBuilder $queryBuilder): void
    {
        $rootAlias = $queryBuilder->getRootAliases()[self::FIRST_ELEMENT_ARRAY];
        $queryBuilder
            ->andWhere($rootAlias . '.user = :user')
            ->setParameter('user', $this->tokenStorage->getToken()->getUser());
    }

}