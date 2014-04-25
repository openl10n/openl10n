<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Key as TranslationKeyModel;

class TranslationKey
{
    public $id;

    /**
     * @Serializer\Type("string")
     */
    public $identifier;

    public $phrases;

    public function __construct(TranslationKeyModel $key)
    {
        $this->id = $key->getId();
        $this->identifier = (string) $key->getIdentifier();
    }
}
