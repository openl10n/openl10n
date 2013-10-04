<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Locale;

/**
 * TranslationKey definition.
 */
interface TranslationKeyInterface
{
    /**
     * The translation domain.
     *
     * @return DomainInterface The translation domain
     */
    public function getDomain();

    /**
     * The translation key identifier.
     *
     * The key is an unique identifier of the translation in its domain.
     * Once set, the key can not be updated.
     *
     * @return string The key identifier
     */
    public function getKey();

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
    public function getHash();

    /**
     * Get all translation for the current key.
     *
     * @return ArrayCollection The list of all translation
     */
    public function getPhrases();

    /**
     * Get the translation for a given locale.
     *
     * @param Locale $locale The locale of the translation
     *
     * @return TranslationPhraseInterface|null The translation or null if it doesn't exist.
     */
    public function getPhrase(Locale $locale);
}
