<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class ImportDomainAction
{
    protected $project;

    public $file;
    public $slug;
    public $locale;
    public $options;

    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }
}
