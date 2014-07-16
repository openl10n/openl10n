<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Value\Localization\Locale;

class TranslationCommit
{
    public $id;

    /**
     * @Serializer\Type("string")
     */
    public $resourceId;

    /**
     * @Serializer\Type("string")
     */
    public $key;

    /**
     * @Serializer\Type("string")
     */
    public $sourceLocale;

    /**
     * @Serializer\Type("string")
     */
    public $sourcePhrase;

    /**
     * @Serializer\Type("string")
     */
    public $targetLocale;

    /**
     * @Serializer\Type("string")
     */
    public $targetPhrase;

    /**
     * @Serializer\Type("boolean")
     */
    public $isTranslated;

    /**
     * @Serializer\Type("boolean")
     */
    public $isApproved;

    public function __construct(Key $key, Locale $source, Locale $target)
    {
        $sourcePhrase = $key->getPhrase($source) ?: new Phrase($key, $source);
        $targetPhrase = $key->getPhrase($target) ?: new Phrase($key, $target);

        $this->id = $key->getId();
        $this->resourceId = $key->getResource()->getId();
        $this->key = (string) $key->getIdentifier();
        $this->sourcePhrase = (string) $sourcePhrase->getText();
        $this->sourceLocale = (string) $sourcePhrase->getLocale();
        $this->targetPhrase = (string) $targetPhrase->getText();
        $this->targetLocale = (string) $targetPhrase->getLocale();
        $this->isTranslated = (null !== $key->getPhrase($source));
        $this->isApproved = $targetPhrase->isApproved();
    }
}
