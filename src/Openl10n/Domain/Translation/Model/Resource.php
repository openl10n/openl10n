<?php

namespace Openl10n\Domain\Translation\Model;

use Rhumsaa\Uuid\Uuid;

class Resource
{
    /**
     * @var Uuid
     */
    protected $uuid;

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var string
     */
    protected $pattern;

    public function __construct(Uuid $uuid, Domain $domain, $pattern)
    {
        $this->uuid = $uuid;
        $this->domain = $domain;
        $this->pattern = $pattern;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }
}
