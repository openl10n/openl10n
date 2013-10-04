<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Object\SlugableName;

/**
 * Project default implementation.
 */
class Project implements ProjectInterface
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
     * @var ArrayCollection
     */
    protected $languages;

    /**
     * @var ArrayCollection
     */
    protected $domains;

    /**
     * Constructor.
     *
     * @param Slug $slug
     */
    public function __construct(Slug $slug)
    {
        $this->slug = $slug;

        // Default attributes
        $this->name = new SlugableName($slug);
        $this->defaultLocale = new Locale('en');
        $this->languages = new ArrayCollection();
        $this->domains = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(Name $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultLocale(Locale $locale)
    {
        $this->defaultLocale = $locale;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * {@inheritdoc}
     */
    public function hasLocale(Locale $locale)
    {
        foreach ($this->languages as $language) {
            if ($locale->equals($language->getLocale())) {
                return true;
            }
        }

        return false;
    }
}
