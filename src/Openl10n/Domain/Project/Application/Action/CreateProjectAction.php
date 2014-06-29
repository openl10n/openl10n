<?php

namespace Openl10n\Domain\Project\Application\Action;

class CreateProjectAction
{
    protected $name;
    protected $slug;
    protected $defaultLocale;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    public function setDefaultLocale($locale)
    {
        $this->defaultLocale = $locale;

        return $this;
    }
}
