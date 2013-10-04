<?php

namespace Openl10n\Bundle\CoreBundle\Entity;

use Openl10n\Bundle\CoreBundle\Model\Domain as BaseDomain;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class Domain extends BaseDomain
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function getSlug()
    {
        if (!$this->slug instanceof Slug) {
            $this->slug = new Slug($this->slug);
        }

        return $this->slug;
    }

    public function getName()
    {
        if (!$this->name instanceof Name) {
            $this->name = new Name($this->name);
        }

        return $this->name;
    }
}
