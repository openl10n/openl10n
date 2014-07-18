<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Key;

class DeleteTranslationKeyAction
{
    /**
     * @var Key
     */
    protected $key;

    public function __construct(Key $key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }
}
