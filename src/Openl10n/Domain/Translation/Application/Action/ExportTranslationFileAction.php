<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Project\Model\Project;

class ExportTranslationFileAction
{
    const OPTION_REVIEWED = 'reviewed';
    const OPTION_FALLBACK_LOCALE = 'fallback_locale';
    const OPTION_FALLBACK_KEY = 'fallback_key';

    /**
     * @var Project
     */
    private $project;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $locale;

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

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

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

    public function hasOptionFallbackLocale()
    {
        return in_array(self::OPTION_FALLBACK_LOCALE, $this->options);
    }

    public function hasOptionFallbackKey()
    {
        return in_array(self::OPTION_FALLBACK_KEY, $this->options);
    }
}
