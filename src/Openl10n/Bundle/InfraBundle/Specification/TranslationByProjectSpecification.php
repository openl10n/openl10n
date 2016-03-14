<?php

namespace Openl10n\Bundle\InfraBundle\Specification;

use Doctrine\ORM\QueryBuilder;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Specification\DoctrineOrmTranslationSpecification;

/**
 * Retrieve all translations (with all their phrases) by a project, and eventually an identifier
 */
class TranslationByProjectSpecification implements DoctrineOrmTranslationSpecification
{
    protected $project;

    protected $identifier;

    public function __construct(Project $project, $identifier = '')
    {
        $this->project = $project;
        $this->identifier = $identifier;
    }

    public function isSatisfiedBy(Key $translationKey)
    {
        return false;
    }

    public function hydrateQueryBuilder(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->leftJoin('k.phrases', 'p')
            ->andWhere('k.project = :project')
            ->orderBy('k.identifier', 'ASC')
            ->setParameters(array(
                'project' => $this->project
            ))
        ;

        if ($this->identifier) {
            $queryBuilder->andWhere('k.identifier = :identifier')->setParameter('identifier', $this->identifier);
        }
    }
}
