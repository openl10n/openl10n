<?php

namespace Openl10n\Bundle\InfraBundle\Specification;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Specification\DoctrineOrmTranslationSpecification;
use Openl10n\Value\Localization\Locale;

class GetTranslationCommitByResource implements DoctrineOrmTranslationSpecification
{
    protected $resource;

    protected $source;
    protected $target;

    public $text;
    public $translated;
    public $approved;

    public function __construct(Resource $resource, Locale $source, Locale $target)
    {
        $this->resource = $resource;
        $this->source = $source;
        $this->target = $target;
    }

    public function isSatisfiedBy(Key $translationKey)
    {
        return false;
    }

    public function hydrateQueryBuilder(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->addSelect('s, t')
            ->leftJoin('k.phrases', 's', Expr\Join::WITH, 's.locale = :source')
            ->leftJoin('k.phrases', 't', Expr\Join::WITH, 't.locale = :target')
            ->andWhere('k.resource = :resource')
            ->orderBy('k.identifier', 'ASC')
            ->setParameters(array(
                'resource' => $this->resource,
                'source' => (string) $this->source,
                'target' => (string) $this->target,
            ))
        ;

        if ($text = $this->text) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('k.identifier', ':text'),
                    $queryBuilder->expr()->like('s.text', ':text'),
                    $queryBuilder->expr()->like('t.text', ':text')
                ))
                ->setParameter('text', '%'.$text.'%')
            ;
        }

        if (null !== $translated = $this->translated) {
            $queryBuilder
                ->andWhere($translated ?
                    $queryBuilder->expr()->isNotNull('t.text') :
                    $queryBuilder->expr()->isNull('t.text')
                )
            ;
        }

        if (null !== $approved = $this->approved) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.isApproved', ':isApproved'))
                ->setParameter('isApproved', $approved)
            ;
        }
    }
}
