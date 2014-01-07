<?php

namespace Openl10n\Bundle\UserBundle\Repository;

use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Model\UserInterface;

/**
 * User repository definition.
 */
interface UserRepositoryInterface
{
    /**
     * Get all users models.
     *
     * @return array List of all users
     */
    public function findAll();

    /**
     * Get a user entity by its username.
     *
     * @param Slug $username Username identifying the user
     *
     * @return UserInterface The user entity
     */
    public function findOneByUsername(Slug $username);
}
