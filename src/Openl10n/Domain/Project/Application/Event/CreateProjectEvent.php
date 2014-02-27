<?php

namespace Openl10n\Domain\Project\Application\Event;

use Symfony\Component\EventDispatcher\Event;
use Openl10n\Domain\Project\Model\Project;

class CreateProjectEvent extends Event
{
    const NAME = 'openl10n.create_project';

    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }
}
