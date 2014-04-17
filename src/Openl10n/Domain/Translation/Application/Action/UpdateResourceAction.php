<?php

namespace Openl10n\Domain\Translation\Application\Action;

use Openl10n\Domain\Translation\Model\Resource;

class UpdateResourceAction
{
    protected $resouce;
    protected $pathname;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
        $this->pathname = (string) $resource->getPathname();
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getPathname()
    {
        return $this->pathname;
    }

    public function setPathname($pathname)
    {
        $this->pathname = $pathname;

        return $this;
    }
}
