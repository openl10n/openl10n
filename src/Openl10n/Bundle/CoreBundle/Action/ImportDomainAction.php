<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class ImportDomainAction
{
    const OPTION_REVIEWED = 'reviewed';
    const OPTION_ERASE = 'erase';
    const OPTION_CLEAN = 'clean';

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

    public function hasOptionReviewed()
    {
        return in_array(self::OPTION_REVIEWED, $this->options);
    }

    public function hasOptionErase()
    {
        return in_array(self::OPTION_ERASE, $this->options);
    }

    public function hasOptionClean()
    {
        return in_array(self::OPTION_CLEAN, $this->options);
    }
}
