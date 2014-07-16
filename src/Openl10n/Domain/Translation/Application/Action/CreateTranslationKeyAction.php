<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Value\Localization\Locale;

class CreateTranslationKeyAction
{
    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var string
     */
    protected $identifier;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }
}
