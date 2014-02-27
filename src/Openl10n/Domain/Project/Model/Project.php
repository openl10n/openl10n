<?php

namespace Openl10n\Domain\Project\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Slug;

class Project
{
    /**
     * @var Slug
     */
    protected $slug;

    /**
     * @var Name
     */
    protected $name;

    /**
     * @var Locale
     */
    protected $defaultLocale;

    /**
     * @var array
     */
    protected $languages;

    public function __construct(Slug $slug)
    {
        $this->slug = $slug;

        // Default attributes
        $this->languages = new ArrayCollection();
    }

    /**
     * The project slug.
     *
     * This is an unique identifier for the project.
     * Once set, the slug could not be modified.
     *
     * @return Slug The project slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * The project name.
     *
     * @return Name The project name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the project name.
     *
     * @param Name $name The project name
     *
     * @return Project The instance of this project
     */
    public function setName(Name $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * The project default locale.
     *
     * @return Locale The project default locale
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * Set the project default locale.
     *
     * @param Locale $locale The project default locale
     *
     * @return Project The instance of this project
     */
    public function setDefaultLocale(Locale $locale)
    {
        $this->defaultLocale = $locale;

        return $this;
    }

    /**
     * Get project's languages.
     *
     * @return ArrayCollection The project's languages
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Add a language.
     *
     * @param Language $language
     *
     * @return Project The instance of this project
     */
    public function addLanguage(Language $language)
    {
        $this->languages->add($language);
    }

    /**
     * Remove a language.
     *
     * @param Language $language
     *
     * @return Project The instance of this project
     */
    public function removeLanguage(Language $language)
    {
        $this->languages->removeElement($language);
    }
}
