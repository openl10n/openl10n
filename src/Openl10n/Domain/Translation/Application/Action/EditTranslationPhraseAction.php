<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Value\Localization\Locale;

class EditTranslationPhraseAction
{
    /**
     * @var Key
     */
    protected $key;

    /**
     * @var Locale
     */
    protected $locale;

    protected $text;
    protected $isApproved;

    public function __construct(Key $key, Locale $locale)
    {
        $this->key = $key;
        $this->locale = $locale;

        if (null !== $phrase = $key->getPhrase($locale)) {
            $this->text = $phrase->getText();
            $this->isApproved = $phrase->isApproved();
        }
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function isApproved()
    {
        return $this->isApproved;
    }

    public function setApproved($isApproved)
    {
        $this->isApproved = $isApproved;

        return $this;
    }
}
