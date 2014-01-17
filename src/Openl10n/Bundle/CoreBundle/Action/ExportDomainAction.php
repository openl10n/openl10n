<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class ExportDomainAction
{
    const OPTION_REVIEWED = 'reviewed';
    const OPTION_FALLBACK_LOCALE = 'fallback_locale';
    const OPTION_FALLBACK_KEY = 'fallback_key';

    protected $project;

    public $locale;
    public $domain;
    public $format;
    public $options;

    public function __construct(ProjectInterface $project)
    {
        $this->project = $project;
        $this->options = array();
    }

    public function getProject()
    {
        return $this->project;
    }

    public function hasOptionReviewed()
    {
        return in_array(self::OPTION_REVIEWED, $this->options);
    }

    public function hasOptionFallbackLocale()
    {
        return in_array(self::OPTION_FALLBACK_LOCALE, $this->options);
    }

    public function hasOptionFallbackKey()
    {
        return in_array(self::OPTION_FALLBACK_KEY, $this->options);
    }
}
