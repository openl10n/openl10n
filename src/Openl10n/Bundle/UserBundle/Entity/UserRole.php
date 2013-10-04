<?php

namespace Openl10n\Bundle\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;

class UserRole implements RoleInterface
{
    private $id;

    private $role;

    private $users;

    public function __construct($role)
    {
        $this->role = $role;
        $this->users = new ArrayCollection();
    }

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    public function addUser($user)
    {
        $this->users->add($user);

        return $this;
    }
}
