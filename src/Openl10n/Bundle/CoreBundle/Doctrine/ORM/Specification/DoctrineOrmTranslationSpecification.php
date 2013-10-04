<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Specification;

use Doctrine\ORM\QueryBuilder;
use Openl10n\Bundle\CoreBundle\Specification\TranslationSpecificationInterface;

interface DoctrineOrmTranslationSpecification extends TranslationSpecificationInterface
{
    public function hydrateQueryBuilder(QueryBuilder $qb);
}
