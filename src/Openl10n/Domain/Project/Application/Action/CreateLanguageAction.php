<?php

namespace Openl10n\Domain\Project\Application\Action;

use Openl10n\Domain\Project\Model\Project;

class CreateLanguageAction
{
    protected $project;
    protected $locale;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
