<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Project\Model\Project;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportTranslationFileAction
{
    const OPTION_REVIEWED = 'reviewed';
    const OPTION_ERASE = 'erase';
    const OPTION_CLEAN = 'clean';

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
    protected $resource;

    /**
     * @var UploadedFile
     */
    protected $file;

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

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;

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

    public function hasOptionErase()
    {
        return in_array(self::OPTION_ERASE, $this->options);
    }

    public function hasOptionClean()
    {
        return in_array(self::OPTION_CLEAN, $this->options);
    }
}
