<?php

namespace Openl10n\Domain\Translation\Model;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Value\Pathname;

class Resource
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @var Pathname
     */
    protected $pathname;

    /**
     * @var string
     */
    protected $hash;

    public function __construct(Project $project, Pathname $pathname)
    {
        $this->project = $project;
        $this->pathname = $pathname;

        $this->computeHash();
    }

    public function getProject()
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    public function getPathname()
    {
        return $this->pathname;
    }

    public function setPathname(Pathname $pathname)
    {
        $this->pathname = $pathname;
        $this->computeHash();

        return $this;
    }

    private function computeHash()
    {
        $this->hash = sha1((string) $this->pathname);
    }
}
