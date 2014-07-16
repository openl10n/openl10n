<?php

namespace Openl10n\Bundle\InfraBundle\Specification;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Specification\DoctrineOrmTranslationSpecification;
use Openl10n\Value\Localization\Locale;

class ResourceLocaleSpecification implements DoctrineOrmTranslationSpecification
{
    protected $resource;
    protected $locale;

    public function __construct(Resource $resource, Locale $locale)
    {
        $this->resource = $resource;
        $this->locale = $locale;
    }

    public function isSatisfiedBy(Key $translationKey)
    {
        return false;
    }

    public function hydrateQueryBuilder(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->leftJoin('k.phrases', 'p', Expr\Join::WITH, 'p.locale = :locale')
            ->andWhere('k.resource = :resource')
            ->orderBy('k.identifier', 'ASC')
            ->setParameters(array(
                'resource' => $this->resource,
                'locale' => (string) $this->locale,
            ))
        ;
    }
}
