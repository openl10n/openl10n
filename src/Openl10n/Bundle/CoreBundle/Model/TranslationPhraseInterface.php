<?php

namespace Openl10n\Bundle\CoreBundle\Model;

/**
 * Translation phrase definition.
 */
interface TranslationPhraseInterface
{
    /**
     * Translation key.
     *
     * @return TranslationKey The translation key
     */
    public function getKey();

    /**
     * Creation date.
     *
     * @return DateTime The creation date
     */
    public function getCreatedAt();

    /**
     * Last update date.
     *
     * @return DateTime The last update date
     */
    public function getUpdatedAt();

    /**
     * The locale associated to the phrase.
     *
     * The locale must be unique by translation key.
     *
     * @return Locale The translation locale
     */
    public function getLocale();

    /**
     * The translation text.
     *
     * @return string The translation text
     */
    public function getText();

    /**
     * Set the translation text.
     *
     * @param string $text The translation text
     *
     * @return TranslationInterface The instance of this object
     */
    public function setText($text);

    /**
     * The approval status of the translation phrase.
     *
     * @return boolean True if the translation is approved in this locale
     */
    public function isApproved();

    /**
     * Set the approval status of the translation phrase.
     *
     * @param boolean $isApproved The approval status
     *
     * @return TranslationInterface The instance of this object
     */
    public function setApproved($isApproved);
}
