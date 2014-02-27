<?php

namespace Openl10n\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Openl10n\Domain\User\Model\Credentials;
use Openl10n\Domain\User\Model\User;
use Openl10n\Bundle\UserBundle\Entity\Credentials as CredentialsEntity;
use Openl10n\Domain\User\Repository\CredentialsRepository as CredentialsRepositoryInterface;

class CredentialsRepository extends EntityRepository implements CredentialsRepositoryInterface
{
    public function createNew(User $user, $password, $salt)
    {
        return new CredentialsEntity($user, $password, $salt);
    }

    public function findOneByUser(User $user)
    {
        return $this->findOneBy(['user' => $user]);
    }

    public function save(Credentials $credentials)
    {
        $this->_em->persist($credentials);
        $this->_em->flush($credentials);
    }

    public function remove(Credentials $credentials)
    {
        $this->_em->remove($credentials);
        $this->_em->flush($credentials);
    }
}
