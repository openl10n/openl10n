<?php

namespace Openl10n\Domain\Translation\Model;

use Rhumsaa\Uuid\Uuid;

class Resource
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var string
     */
    protected $pattern;

    public function __construct(Domain $domain, $pattern)
    {
        $this->domain = $domain;
        $this->pattern = $pattern;
    }

    /**
     * Entity identifiant.
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
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
