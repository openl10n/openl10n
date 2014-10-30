<?php

namespace Openl10n\Bundle\InfraBundle\Entity;

use Openl10n\Domain\Project\Model\Project as BaseProject;
use Openl10n\Value\String\Slug;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Description;
use Openl10n\Value\Localization\Locale;

class Project extends BaseProject
{
    public function getDefaultLocale()
    {
        if (!$this->defaultLocale instanceof Locale) {
            $this->defaultLocale = Locale::parse($this->defaultLocale);
        }

        return $this->defaultLocale;
    }

    public function getSlug()
    {
        if (!$this->slug instanceof Slug) {
            $this->slug = new Slug($this->slug);
        }

        return $this->slug;
    }

    public function getName()
    {
        if (!$this->name instanceof Name) {
            $this->name = new Name($this->name);
        }

        return $this->name;
    }

    public function getDescription()
    {
        if (!$this->description instanceof Description) {
            $this->description = new Description($this->description);
        }

        return $this->description;
    }
}
