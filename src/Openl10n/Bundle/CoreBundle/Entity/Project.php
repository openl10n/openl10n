<?php

namespace Openl10n\Bundle\CoreBundle\Entity;

use Openl10n\Bundle\CoreBundle\Model\Project as BaseProject;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class Project extends BaseProject
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function getSlug()
    {
        if (!$this->slug instanceof Slug) {
            $this->slug = new Slug($this->slug);
        }

        return $this->slug;
    }

    public function getDefaultLocale()
    {
        if (!$this->defaultLocale instanceof Locale) {
            $this->defaultLocale = new Locale($this->defaultLocale);
        }

        return $this->defaultLocale;
    }

    protected function createLocale(Locale $locale)
    {
        return new Language($this, $locale);
    }
}
