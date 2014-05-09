<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Resource\Model\Resource as ResourceModel;

class Resource
{
    public $id;

    public $project;

    /**
     * @Serializer\Type("string")
     */
    public $pathname;

    public function __construct(ResourceModel $resource)
    {
        $this->id = $resource->getId();
        $this->project = (string) $resource->getProject()->getSlug();
        $this->pathname = (string) $resource->getPathname();
    }
}
