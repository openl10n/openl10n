<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Project\Model\Project;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateResourceAction
{
    const OPTION_REVIEWED = 'reviewed';

    /**
     * @var Project
     */
    private $project;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $pathname;

    /**
     * @var array
     */
    protected $options;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->options = [];
    }

    public function getProject()
    {
        return $this->project;
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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function hasOptionReviewed()
    {
        return in_array(self::OPTION_REVIEWED, $this->options);
    }
}
