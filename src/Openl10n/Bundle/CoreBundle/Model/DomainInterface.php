<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Name;

/**
 * Domain definition.
 */
interface DomainInterface
{
    /**
     * The project which the domain belongs to.
     *
     * @return ProjectInterface
     */
    public function getProject();

    /**
     * The domain slug.
     *
     * This slug is an unique identifier of the domain, inside a project.
     * Two domains of different project could have the same slug.
     * Once set, the slug could not be modified.
     *
     * @return Slug The domain slug
     */
    public function getSlug();

    /**
     * The domain name.
     *
     * @return Name The domain name
     */
    public function getName();

    /**
     * Set the domain name.
     *
     * @param Name $name The domain name
     *
     * @return DomainInterface The instance of this domain
     */
    public function setName(Name $name);
}
