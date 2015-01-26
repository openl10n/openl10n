<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Value\Localization\Locale;

class EditTranslationMetaAction
{
    /**
     * @var Key
     */
    protected $key;

    /**
     * @var string
     */
    protected $description;

    public function __construct(Key $key)
    {
        $this->key = $key;

        $this->description = $key->getMeta()->getDescription();
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
