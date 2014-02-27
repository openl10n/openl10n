<?php

namespace Openl10n\Domain\User\Repository;

use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Value\Username;

interface UserRepository
{
    public function createNew(Username $username);
    public function findOneByUsername(Username $username);
    public function save(User $user);
    public function remove(User $user);
}
