<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Bundle\InfraBundle\Entity\Language as LanguageEntity;
use Openl10n\Domain\Project\Repository\LanguageRepository as LanguageRepositoryInterface;
use Openl10n\Value\Localization\Locale;

class LanguageRepository extends EntityRepository implements LanguageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(Project $project, Locale $locale)
    {
        return new LanguageEntity($project, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function findByProject(Project $project)
    {
        return $this->findBy(['project' => $project]);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByProject(Project $project, Locale $locale)
    {
        return $this->findOneBy([
            'project' => $project,
            'locale' => (string) $locale
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Language $language)
    {
        $this->_em->persist($language);
        $this->_em->flush($language);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Language $language)
    {
        $this->_em->remove($language);
        $this->_em->flush($language);
    }
}
