<?php

namespace Openl10n\Domain\User\Repository;

use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Model\Credentials;

interface CredentialsRepository
{
    public function createNew(User $user, $password, $salt);
    public function findOneByUser(User $user);
    public function save(Credentials $credentials);
    public function remove(Credentials $credentials);
}
