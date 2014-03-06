<?php

namespace Openl10n\Bundle\EditorBundle\Translation;

use Doctrine\ORM\Query\Expr;
use Openl10n\Domain\Project\Model\Project;
use Doctrine\ORM\QueryBuilder;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Specification\DoctrineOrmTranslationSpecification;
use Openl10n\Value\Localization\Locale;

class CustomTranslationSpecification implements DoctrineOrmTranslationSpecification
{
    protected $project;

    protected $source;
    protected $target;

    public $domain;
    public $text;
    public $translated;
    public $approved;

    public function __construct(Project $project, Locale $source, Locale $target)
    {
        $this->project = $project;
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
            ->leftJoin('k.domain', 'd')
            ->andWhere('d.project = :project')
            ->orderBy('k.identifier', 'ASC')
            ->setParameters(array(
                'project' => $this->project,
                'source' => (string) $this->source,
                'target' => (string) $this->target,
            ))
        ;

        if (null !== $domain = $this->domain) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('d.slug', ':domain'))
                ->setParameter('domain', $domain)
            ;
        }

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
