<?php

namespace Openl10n\Domain\Project\Application\Event;

use Symfony\Component\EventDispatcher\Event;
use Openl10n\Domain\Project\Model\Project;

class EditProjectEvent extends Event
{
    const NAME = 'openl10n.edit_project';

    protected $project;
    protected $oldProject;

    public function __construct(Project $project, Project $oldProject)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getOldProject()
    {
        return $this->oldProject;
    }
}
