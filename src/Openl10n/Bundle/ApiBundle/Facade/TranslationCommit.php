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
        $source = $key->getPhrase($source) ?: new Phrase($key, $source);
        $target = $key->getPhrase($target) ?: new Phrase($key, $target);

        $this->id = $key->getId();
        $this->resouceId = $key->getResource()->getId();
        $this->key = (string) $key->getIdentifier();
        $this->sourcePhrase = (string) $source->getText();
        $this->sourceLocale = (string) $source->getLocale();
        $this->targetPhrase = (string) $target->getText();
        $this->targetLocale = (string) $target->getLocale();
        $this->isTranslated = !empty($target->getText());
        $this->isApproved = $target->isApproved();
    }
}
