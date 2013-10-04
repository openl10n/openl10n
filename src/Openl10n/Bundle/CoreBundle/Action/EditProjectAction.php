<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class EditProjectAction
{
    protected $project;

    public $name;
    public $defaultLocale;

    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
        $this->name = (string) $project->getName();
        $this->defaultLocale = (string) $project->getDefaultLocale();
    }

    public function getProject()
    {
        return $this->project;
    }
}
