<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Value\Localization\Locale;

class DeleteTranslationKeyAction
{
    /**
     * @var Key
     */
    protected $resource;

    public function __construct(Key $key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }
}
