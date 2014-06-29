<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Phrase as TranslationPhraseModel;

class TranslationPhrase
{
    /**
     * @Serializer\Type("string")
     */
    public $locale;

    /**
     * @Serializer\Type("string")
     */
    public $text;

    /**
     * @Serializer\Type("boolean")
     */
    protected $isApproved;

    /**
     * @Serializer\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @Serializer\Type("DateTime")
     */
    protected $updatedAt;

    public function __construct(TranslationPhraseModel $phrase)
    {
        $this->locale = $phrase->getLocale();
        $this->text = $phrase->getText();
        $this->isApproved = $phrase->isApproved();
        $this->createdAt = $phrase->getCreatedAt();
        $this->updatedAt = $phrase->getUpdatedAt();
    }
}
