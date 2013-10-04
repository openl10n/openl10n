<?php

namespace Openl10n\Bundle\CoreBundle\EventDispatcher\Event;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Symfony\Component\EventDispatcher\Event;

class ProjectEvent extends Event
{
    /**
     * @var ProjectInterface
     */
    protected $project;

    /**
     * @param ProjectInterface $project
     */
    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }

    /**
     * @return ProjectInterface
     */
    public function getProject()
    {
        return $this->project;
    }
}
