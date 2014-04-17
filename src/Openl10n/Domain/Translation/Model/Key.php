<?php

namespace Openl10n\Domain\Translation\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Openl10n\Value\Localization\Locale;

class Key
{
    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var StringIdentifier
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var ArrayCollection
     */
    protected $phrases;

    public function __construct(Resource $resource, StringIdentifier $identifier)
    {
        $this->resource = $resource;
        $this->identifier = $identifier;

        $this->computeHash();

        $this->phrases = new ArrayCollection();
    }

    /**
     * The translation resource.
     *
     * @return Resource The translation resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * The translation key identifier.
     *
     * This is an unique identifier of the translation in its domain.
     * Once set, the key can not be updated.
     *
     * @return StringIdentifier The key identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get all translation for the current key.
     *
     * @return ArrayCollection The list of all translation
     */
    public function getPhrases()
    {
        return $this->phrases;
    }

    /**
     * Determine if a phrase has translated into given locale.
     *
     * @param Locale $locale The locale of the translation to check
     *
     * @return boolean.
     */
    public function hasPhrase(Locale $locale)
    {
        foreach ($this->phrases as $phrase) {
            if ((string) $locale === (string) $phrase->getLocale()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the translation for a given locale.
     *
     * @param Locale $locale The locale of the translation
     *
     * @return Phrase|null The translation or null if it doesn't exist.
     */
    public function getPhrase(Locale $locale)
    {
        foreach ($this->phrases as $phrase) {
            if ((string) $locale === (string) $phrase->getLocale()) {
                return $phrase;
            }
        }

        return null;
    }

    /**
     * Add a translation phrase.
     *
     * @param Phrase $phrase Translation phrase
     */
    public function addPhrase(Phrase $phrase)
    {
        $this->phrases->add($phrase);

        return $this;
    }

    private function computeHash()
    {
        $this->hash = sha1((string) $this->identifier);
    }
}
