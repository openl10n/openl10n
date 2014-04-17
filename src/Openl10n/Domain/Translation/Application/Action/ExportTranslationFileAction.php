<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Resource;

class ExportTranslationFileAction
{
    const OPTION_REVIEWED = 'reviewed';
    const OPTION_FALLBACK_LOCALE = 'fallback_locale';
    const OPTION_FALLBACK_KEY = 'fallback_key';

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var array
     */
    protected $options;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
        $this->options = [];
    }

    public function getResource()
    {
        return $this->resource;
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

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;

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
