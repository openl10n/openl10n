<?php

namespace Openl10n\Domain\Translation\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Value\Hash;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Openl10n\Value\Localization\Locale;

class Meta
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Key
     */
    protected $key;

    /**
     * @var string
     */
    protected $description;

    public function __construct(Key $key)
    {
        $this->key = $key;
        $this->description = '';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set a description text.
     *
     * @param string $description
     *
     * @return Meta The instance of the object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
