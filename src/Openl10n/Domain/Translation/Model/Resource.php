<?php

namespace Openl10n\Domain\Translation\Model;

use Openl10n\Domain\Project\Model\Project;

class Resource
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @var string
     */
    protected $pattern;

    public function __construct(Project $project, $pattern)
    {
        $this->project = $project;
        $this->pattern = $pattern;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }
}
