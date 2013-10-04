<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;

/**
 * Project definition.
 */
interface ProjectInterface
{
    /**
     * The project slug.
     *
     * This is an unique identifier for the project.
     * Once set, the slug could not be modified.
     *
     * @return Slug The project slug
     */
    public function getSlug();

    /**
     * The project name.
     *
     * @return Name The project name
     */
    public function getName();

    /**
     * Set the project name.
     *
     * @param Name $name The project name
     *
     * @return ProjectInterface The instance of this project
     */
    public function setName(Name $name);

    /**
     * The project default locale.
     *
     * @return Locale The project default locale
     */
    public function getDefaultLocale();

    /**
     * Set the project default locale.
     *
     * @param Locale $locale The project default locale
     *
     * @return ProjectInterface The instance of this project
     */
    public function setDefaultLocale(Locale $locale);

    /**
     * Get the locales in which the project is translated.
     *
     * @return ArrayCollection List of Languages
     */
    public function getLanguages();

    /**
     * Determine in project has a given locale.
     *
     * @return Boolean True if the locale exists in the project
     */
    public function hasLocale(Locale $locale);
}
