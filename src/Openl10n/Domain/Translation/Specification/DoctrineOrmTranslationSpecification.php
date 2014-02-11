<?php

namespace Openl10n\Domain\Translation\Specification;

use Doctrine\ORM\QueryBuilder;

interface DoctrineOrmTranslationSpecification extends TranslationSpecification
{
    public function hydrateQueryBuilder(QueryBuilder $queryBuilder);
}
