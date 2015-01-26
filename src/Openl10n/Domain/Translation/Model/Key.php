<?php

namespace Openl10n\Domain\Translation\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Value\Hash;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Openl10n\Value\Localization\Locale;

class Key
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \Openl10n\Domain\Project\Model\Project
     */
    protected $project;

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
     * @var Meta
     */
    protected $meta;

    /**
     * @var ArrayCollection
     */
    protected $phrases;

    public function __construct(Resource $resource, StringIdentifier $identifier)
    {
        $this->project = $resource->getProject();
        $this->resource = $resource;
        $this->identifier = $identifier;
        $this->hash = new Hash($this->identifier);
        $this->meta = null;

        $this->phrases = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The project where belong the translation .
     *
     * @return Project The project
     */
    public function getProject()
    {
        return $this->project;
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
     * The translation hash identifier.
     *
     * @return Hash
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
     * Get the meta of the translation.
     *
     * @return Meta
     */
    public function getMeta()
    {
        if (null === $this->meta) {
            $this->meta = $this->createNewMeta();
        }

        return $this->meta;
    }

    /**
     * Create a new meta object.
     *
     * @return Meta
     */
    protected function createNewMeta()
    {
        return new Meta();
    }
}
