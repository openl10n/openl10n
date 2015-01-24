<?php

namespace Openl10n\Bundle\InfraBundle\Entity;

use Openl10n\Domain\Translation\Model\Key as BaseKey;

class Key extends BaseKey
{
    protected function createNewMeta()
    {
        return new Meta();
    }
}
