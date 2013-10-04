<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class ExportDomainAction
{
    protected $project;

    public $locale;
    public $domain;
    public $format;
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
