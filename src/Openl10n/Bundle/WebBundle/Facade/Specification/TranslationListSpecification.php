<?php

namespace Openl10n\Bundle\WebBundle\Facade\Specification;

use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\WebBundle\Facade\Model\TranslationFilterBag;
use Openl10n\Bundle\CoreBundle\Doctrine\ORM\Specification\DoctrineOrmTranslationSpecification;
use Doctrine\ORM\Query\Expr;
use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;
use Doctrine\ORM\QueryBuilder;
use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Context\TranslationContext;


class TranslationListSpecification implements DoctrineOrmTranslationSpecification
{
    protected $domain;
    protected $source;
    protected $target;
    protected $filterBag;

    public function __construct(
        DomainInterface $domain,
        TranslationContext $context,
        TranslationFilterBag $filterBag = null
    )
    {
        $this->domain = $domain;

        $this->source = $context->getSource();
        $this->target = $context->getTarget();

        $this->filterBag = $filterBag ?: new TranslationFilterBag();
    }

    public function hydrateQueryBuilder(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->addSelect('s, t')
            ->leftJoin('k.phrases', 's', Expr\Join::WITH, 's.locale = :source')
            ->leftJoin('k.phrases', 't', Expr\Join::WITH, 't.locale = :target')
            ->andWhere('k.domain = :domain')
            ->orderBy('k.key', 'ASC')
            ->setParameters(array(
                'domain' => $this->domain,
                'source' => $this->source,
                'target' => $this->target,
            ))
        ;

        if ($text = $this->filterBag->text) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('k.key', ':text'),
                    $queryBuilder->expr()->like('s.text', ':text'),
                    $queryBuilder->expr()->like('t.text', ':text')
                ))
                ->setParameter('text', '%'.$text.'%')
            ;
        }

        if (null !== $translated = $this->filterBag->translated) {
            $queryBuilder
                ->andWhere($translated ?
                    $queryBuilder->expr()->isNotNull('t.text') :
                    $queryBuilder->expr()->isNull('t.text')
                )
            ;
        }

        if (null !== $approved = $this->filterBag->approved) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('t.isApproved', ':isApproved'))
                ->setParameter('isApproved', $approved)
            ;
        }
    }

    public function isSatisfiedBy(TranslationKeyInterface $translationKey)
    {
        throw new \BadMethodCallException('Not implemented');
    }
}
