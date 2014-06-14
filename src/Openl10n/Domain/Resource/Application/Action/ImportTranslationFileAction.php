<?php

namespace Openl10n\Domain\Resource\Application\Action;

use Openl10n\Domain\Resource\Model\Resource;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportTranslationFileAction
{
    const OPTION_REVIEWED = 'reviewed';
    const OPTION_ERASE = 'erase';
    const OPTION_CLEAN = 'clean';

    /**
     * @var Resource
     */
    private $resource;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $locale;

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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

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
