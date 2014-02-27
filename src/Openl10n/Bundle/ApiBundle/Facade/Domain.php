<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Translation\Model\Domain as DomainModel;

class Domain
{
    /**
     * @Serializer\Type("string")
     */
    public $slug;

    /**
     * @Serializer\Type("string")
     */
    public $name;

    public function __construct(DomainModel $domain)
    {
        $this->slug = (string) $domain->getSlug();
        $this->name = (string) $domain->getName();
    }
}
