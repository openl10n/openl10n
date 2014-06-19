<?php

namespace Openl10n\Domain\Project\Repository;

use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\Localization\Locale;

interface LanguageRepository
{
    /**
     * Create new language.
     *
     * @param Project $project Project
     * @param Locale  $locale  Locale
     *
     * @return Language A new project instance
     */
    public function createNew(Project $project, Locale $locale);

    /**
     * Find all project's language.
     *
     * @param Project $project
     *
     * @return array Array of project's languages
     */
    public function findByProject(Project $project);

    /**
     * Find one project's language.
     *
     * @param Project $project
     * @param Locale  $locale
     *
     * @return array Array of project's languages
     */
    public function findOneByProject(Project $project, Locale $locale);

    /**
     * Save a language.
     *
     * @param Language $language The language to save
     */
    public function save(Language $language);

    /**
     * Remove a language.
     *
     * @param Language $language The language to remove
     */
    public function remove(Language $language);
}
