<?php

namespace Openl10n\Bundle\CoreBundle\Entity;

use Openl10n\Bundle\CoreBundle\Model\TranslationKey as BaseTranslationKey;

class TranslationKey extends BaseTranslationKey
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
