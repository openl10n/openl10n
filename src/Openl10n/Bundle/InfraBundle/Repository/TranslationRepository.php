<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Openl10n\Bundle\InfraBundle\Entity\Key as KeyEntity;
use Openl10n\Bundle\InfraBundle\Entity\Phrase as PhraseEntity;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Repository\TranslationRepository as TranslationRepositoryInterface;
use Openl10n\Domain\Translation\Specification\DoctrineOrmTranslationSpecification;
use Openl10n\Domain\Translation\Specification\TranslationSpecification;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Openl10n\Value\Localization\Locale;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class TranslationRepository extends EntityRepository implements TranslationRepositoryInterface
{
    public function createNewKey(Resource $resource, StringIdentifier $identifier)
    {
        return new KeyEntity($resource, $identifier);
    }

    public function createNewPhrase(Key $key, Locale $locale, $text = '')
    {
        return new PhraseEntity($key, $locale, $text);
    }

    public function findByResource(Resource $resource)
    {
        return $this->findBy(['resource' => $resource], ['identifier' => 'ASC']);
    }

    public function findOneById($id)
    {
        return $this->find($id);
    }

    public function findOneByKey(Resource $resource, $identifier)
    {
        return $this->findOneBy(['resource' => $resource, 'identifier' => $identifier]);
    }

    public function findOneByHash(Project $project, $hash)
    {
        $queryBuilder = $this->createQueryBuilder('k')
            ->select('k')
            ->leftJoin('k.resource', 'r')
            ->leftJoin('r.domain', 'd')
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

    public function findSatisfying(TranslationSpecification $specification)
    {
        if ($specification instanceof DoctrineOrmTranslationSpecification) {
            $queryBuilder = $this->createQueryBuilder('k');
            $queryBuilder->select('k');
            $specification->hydrateQueryBuilder($queryBuilder);

            $adapter = new DoctrineORMAdapter($queryBuilder);

            return new Pagerfanta($adapter);
        }

        $translations = [];

        $translationsKeys = $this->findAll();
        foreach ($translationsKeys as $key) {
            if ($specification->isSatisfiedBy($key)) {
                $translations[] = $key;
            }
        }

        $adapter = new ArrayAdapter($translations);

        return new Pagerfanta($adapter);
    }

    public function saveKey(Key $key)
    {
        $this->_em->persist($key);
        $this->_em->flush($key);
    }

    public function savePhrase(Phrase $phrase)
    {
        $this->_em->persist($phrase);
        $this->_em->flush($phrase);
    }

    public function removeKey(Key $key)
    {
        $this->_em->remove($key);
        $this->_em->flush($key);
    }

    public function removePhrase(Phrase $phrase)
    {
        $this->_em->remove($phrase);
        $this->_em->flush($phrase);
    }
}
