<?php

namespace Openl10n\Domain\Translation\Repository;

use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Domain\Translation\Model\Resource;
use Openl10n\Value\String\Slug;
use Rhumsaa\Uuid\Uuid;

interface ResourceRepository
{
    public function createNew(Domain $resource, Uuid $uuid, $pattern);

    public function findOneByUuid(Domain $domain, Uuid $uuid);

    public function save(Resource $resource);

    public function remove(Resource $resource);
}
