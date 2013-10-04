<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class SwitchTranslationContextAction
{
    protected $project;

    public $source;
    public $target;

    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }
}
