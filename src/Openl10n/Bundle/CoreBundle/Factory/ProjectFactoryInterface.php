<?php

namespace Openl10n\Bundle\CoreBundle\Factory;

use Openl10n\Bundle\CoreBundle\Object\Slug;

interface ProjectFactoryInterface
{
    public function createNew(Slug $slug);
}
