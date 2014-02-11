<?php

namespace Openl10n\Domain\Translation\Model;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Slug;

class Domain
{
    /**
     * @var Project
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

    public function __construct(Project $project, Slug $slug)
    {
        $this->project = $project;
        $this->slug = $slug;
        $this->name = new Name((string) $slug);
    }

    /**
     * The project which the domain belongs to.
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * The domain slug.
     *
     * This slug is an unique identifier of the domain, inside a project.
     * Two domains of different project could have the same slug.
     * Once set, the slug could not be modified.
     *
     * @return Slug The domain slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * The domain name.
     *
     * @return Name The domain name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the domain name.
     *
     * @param Name $name The domain name
     *
     * @return DomainInterface The instance of this domain
     */
    public function setName(Name $name)
    {
        $this->name = $name;

        return $this;
    }
}
