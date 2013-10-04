<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Openl10n\Bundle\CoreBundle\Doctrine\ORM\Specification\DoctrineOrmTranslationSpecification;
use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Model\Translation;
use Openl10n\Bundle\CoreBundle\Repository\TranslationRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Specification\TranslationSpecificationInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class TranslationRepository implements TranslationRepositoryInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function findOneByKey(DomainInterface $domain, $key)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:TranslationKey')
            ->findOneBy(array('domain' => $domain, 'key' => $key))
        ;
    }

    public function findOneByHash(ProjectInterface $project, $hash)
    {
        $queryBuilder = $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:TranslationKey')
            ->createQueryBuilder('k')
        ;

        $queryBuilder
            ->select('k')
            ->leftJoin('k.domain', 'd')
            ->where('d.project = :project')
            ->andWhere('k.hash = :hash')
            ->setParameters(array(
                'project' => $project,
                'hash' => $hash,
            ))
            ->setMaxResults(1)
        ;

        $result = $queryBuilder->getQuery()->getResult();

        return array_pop($result);
    }

    public function findAll()
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:TranslationKey')
            ->findAll()
        ;
    }

    public function findSatisfying(TranslationSpecificationInterface $spec)
    {
        if (!$spec instanceof DoctrineOrmTranslationSpecification) {
            throw new \BadMethodCallException('Translation Repository only work with doctrine for now');
        }

        $queryBuilder = $this->createQueryBuilder();
        $spec->hydrateQueryBuilder($queryBuilder);

        return $queryBuilder->getQuery()->getResult();;
    }

    public function paginateSatisfying(TranslationSpecificationInterface $spec)
    {
        if (!$spec instanceof DoctrineOrmTranslationSpecification) {
            throw new \BadMethodCallException('Translation Repository only work with doctrine for now');
        }

        $queryBuilder = $this->createQueryBuilder();
        $spec->hydrateQueryBuilder($queryBuilder);

        $adapter = new DoctrineORMAdapter($queryBuilder);

        return new Pagerfanta($adapter);
    }

    private function createQueryBuilder()
    {
        $queryBuilder = $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:TranslationKey')
            ->createQueryBuilder('k')
        ;

        $queryBuilder->select('k');

        return $queryBuilder;
    }
}
