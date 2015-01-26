<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Meta as TranslationMetaModel;

class TranslationMeta
{
    /**
     * @Serializer\Type("string")
     */
    public $description;

    public function __construct(TranslationMetaModel $meta)
    {
        $this->description = $meta->getDescription();
    }
}
