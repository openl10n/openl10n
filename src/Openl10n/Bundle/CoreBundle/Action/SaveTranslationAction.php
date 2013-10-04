<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;

class SaveTranslationAction
{
    protected $key;
    protected $locale;

    public $text = '';
    public $isApproved = false;

    public function __construct(TranslationKeyInterface $key, Locale $locale)
    {
        $this->key = $key;
        $this->locale = $locale;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getLocale()
    {
        return $this->locale;
    }
}
