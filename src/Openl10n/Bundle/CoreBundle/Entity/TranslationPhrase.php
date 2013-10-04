<?php

namespace Openl10n\Bundle\CoreBundle\Entity;

use Openl10n\Bundle\CoreBundle\Model\TranslationPhrase as BaseTranslationPhrase;
use Openl10n\Bundle\CoreBundle\Object\Locale;

class TranslationPhrase extends BaseTranslationPhrase
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function getLocale()
    {
        if (!$this->locale instanceof Locale) {
            $this->locale = new Locale($this->locale);
        }

        return $this->locale;
    }
}
