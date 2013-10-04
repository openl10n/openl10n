<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Object\SlugableName;

/**
 * Domain default implementation.
 */
class Domain implements DomainInterface
{
    /**
     * @var ProjectInterface
     */
    protected $project;

    /**
     * @var Slug
     */
    protected $slug;

    /**
     * @var Name
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $keys;

    /**
     * Constructor.
     *
     * @param ProjectInterface $project The domain's project
     * @param Slug             $slug    The domain's slug
     */
    public function __construct(ProjectInterface $project, Slug $slug)
    {
        $this->project = $project;
        $this->slug = $slug;

        // Default attributes
        $this->name = new SlugableName($slug);
        $this->keys = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(Name $name)
    {
        $this->name = $name;

        return $this;
    }
}
