<?php

namespace Openl10n\Domain\Translation\Model;

use Openl10n\Value\Localization\Locale;

class Phrase
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Key
     */
    protected $key;

    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var boolean
     */
    protected $isApproved;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * Constructor.
     *
     * @param Key    $key    The translation key
     * @param Locale $locale The locale of the text
     * @param string $text   The text
     */
    public function __construct(Key $key, Locale $locale, $text = '')
    {
        $this->key = $key;
        $this->locale = $locale;
        $this->text = $text;

        // Default attributes
        $this->isApproved = false;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Translation key.
     *
     * @return TranslationKey The translation key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Creation date.
     *
     * @return DateTime The creation date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Last update date.
     *
     * @return DateTime The last update date
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * The locale associated to the phrase.
     *
     * The locale must be unique by translation key.
     *
     * @return Locale The translation locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * The translation text.
     *
     * @return string The translation text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the translation text.
     *
     * @param string $text The translation text
     *
     * @return TranslationInterface The instance of this object
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * The approval status of the translation phrase.
     *
     * @return boolean True if the translation is approved in this locale
     */
    public function isApproved()
    {
        return $this->isApproved;
    }

    /**
     * Set the approval status of the translation phrase.
     *
     * @param boolean $isApproved The approval status
     *
     * @return TranslationInterface The instance of this object
     */
    public function setApproved($isApproved)
    {
        $this->isApproved = $isApproved;
    }
}
