<?php

namespace Openl10n\Domain\User\Repository;

use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Model\Credentials;

interface CredentialsRepository
{
    /**
     * @param string $password
     * @param \Prophecy\Argument\Token\TypeToken $salt
     *
     * @return \Openl10n\Bundle\UserBundle\Entity\Credentials
     */
    public function createNew(User $user, $password, $salt);
    public function findOneByUser(User $user);
    public function save(Credentials $credentials);
    public function remove(Credentials $credentials);
}
