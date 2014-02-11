<?php

namespace Openl10n\Domain\Project\Application\Action;

use Openl10n\Domain\Project\Model\Project;

class EditProjectAction
{
    protected $project;
    protected $name;
    protected $defaultLocale;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->name = (string) $project->getName();
        $this->defaultLocale = (string) $project->getDefaultLocale();
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

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
