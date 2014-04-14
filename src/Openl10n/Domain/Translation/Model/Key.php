<?php

namespace Openl10n\Domain\Translation\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Value\Localization\Locale;

class Key
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * @var Resource
     */
    protected $resource;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var array
     */
    protected $phrases;

    public function __construct(Resource $resource, $identifier)
    {
        $this->resource = $resource;
        $this->identifier = $identifier;

        // Generate hash
        $this->hash = sha1(/*$resource->getDomain()->getSlug().*/'#'.$identifier);

        $this->phrases = new ArrayCollection();
    }

    /**
     * Entity identifiant.
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
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
     * @return string The key identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * The translation hash.
     *
     * The hash is an unique identifier of the translation in the whole
     * project. Usually, the hash combines the domain's slug (which is
     * unique in the project), and the its own key (which is unique in
     * the domain).
     *
     * As the key and domain are immutable, the hash must be set during
     * object construction and never updated.
     *
     * @return string The translation hash.
     */
    public function getHash()
    {
        return $this->hash;
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

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getIdentifier();
    }
}
