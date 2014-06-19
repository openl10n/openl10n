<?php

namespace Openl10n\Domain\Resource\Application\Action;

use Openl10n\Domain\Project\Model\Project;

class CreateResourceAction
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @var string
     */
    protected $pathname;

    /**
     * @var array
     */
    protected $options;

    public function __construct()
    {
        $this->options = [];
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    public function getPathname()
    {
        return $this->pathname;
    }

    public function setPathname($pathname)
    {
        $this->pathname = $pathname;

        return $this;
    }
}
