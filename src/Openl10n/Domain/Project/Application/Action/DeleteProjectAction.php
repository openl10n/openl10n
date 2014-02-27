<?php

namespace Openl10n\Domain\Project\Application\Action;

use Openl10n\Domain\Project\Model\Project;

class DeleteProjectAction
{
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
