<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Locale;

class Language implements LanguageInterface
{
    protected $project;
    protected $locale;

    public function __construct(ProjectInterface $project, Locale $locale)
    {
        $this->project = $project;
        $this->locale = $locale;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
