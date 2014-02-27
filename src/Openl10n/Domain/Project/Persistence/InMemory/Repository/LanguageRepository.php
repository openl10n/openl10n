<?php

namespace Openl10n\Domain\Project\Persistence\InMemory\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Repository\LanguageRepository as LanguageRepositoryInterface;
use Openl10n\Value\Localization\Locale;

class LanguageRepository implements LanguageRepositoryInterface
{
    protected $languages;

    public function __construct()
    {
        $this->languages = array();
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(Project $project, Locale $locale)
    {
        return new Language($project, $locale);
    }

    /**
     * {@inheritdoc}
     */
    public function findByProject(Project $project)
    {
        return $this->getLanguagesBag($project)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByProject(Project $project, Locale $locale)
    {
        foreach ($this->getLanguagesBag($project) as $language) {
            if ((string) $language->getLocale() === (string) $locale) {
                return $language;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Language $language)
    {
        $project = $language->getProject();
        if (!$this->getLanguagesBag($project)->contains($language)) {
            $this->getLanguagesBag($project)->add($language);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Language $language)
    {
        $project = $language->getProject();
        if (!$this->getLanguagesBag($project)->contains($language)) {
            $this->getLanguagesBag($project)->removeElement($language);
        }
    }

    private function getLanguagesBag(Project $project)
    {
        $slug = (string) $project->getSlug();
        if (!isset($this->languages[$slug])) {
            $this->languages[$slug] = new ArrayCollection();
        }

        return $this->languages[$slug];
    }
}
