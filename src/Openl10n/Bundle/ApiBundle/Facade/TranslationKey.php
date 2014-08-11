<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Key as TranslationKeyModel;

class TranslationKey
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"item"})
     */
    public $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Groups({"item"})
     */
    public $identifier;

    /**
     * @Serializer\Type("integer")
     * @Serializer\Groups({"item"})
     */
    public $resourceId;

    /**
     * @Serializer\Type("array<string, Openl10n\Bundle\ApiBundle\Facade\TranslationPhrase>")
     */
    public $phrases;

    public function __construct(TranslationKeyModel $key, $withPhrases = false)
    {
        $this->id = $key->getId();
        $this->identifier = (string) $key->getIdentifier();
        $this->resourceId = $key->getResource()->getId();

        if ($withPhrases) {
            foreach ($key->getPhrases() as $phrase) {
                $locale = $phrase->getLocale();
                $this->phrases[(string) $locale] = new TranslationPhrase($phrase);
            }
        }
    }
}
