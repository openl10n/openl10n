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
     * @Serializer\Type("array<Openl10n\Bundle\ApiBundle\Facade\TranslationPhrase>")
     */
    public $phrases;

    public function __construct(TranslationKeyModel $key)
    {
        $this->id = $key->getId();
        $this->identifier = (string) $key->getIdentifier();
    }
}
