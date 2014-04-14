<?php

namespace Openl10n\Domain\Project\Model;

use Openl10n\Value\Localization\Locale;

class Language
{
    /**
     * @var int|string
     */
    protected $id;

    protected $project;
    protected $locale;

    public function __construct(Project $project, Locale $locale)
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
