<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Resource as ResourceModel;

class Resource
{
    /**
     * xSerializer\Type("int")
     */
    public $id;

    /**
     * @Serializer\Type("string")
     */
    public $pathname;

    public function __construct(ResourceModel $resource)
    {
        $this->id = $resource->getId();
        $this->pathname = (string) $resource->getPathname();
    }
}
