<?php

namespace Openl10n\Domain\User\Repository;

use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Value\Username;

interface UserRepository
{
    /**
     * @return \Openl10n\Bundle\UserBundle\Entity\User
     */
    public function createNew(Username $username);
    public function findOneByUsername(Username $username);
    public function save(User $user);
    public function remove(User $user);
}
