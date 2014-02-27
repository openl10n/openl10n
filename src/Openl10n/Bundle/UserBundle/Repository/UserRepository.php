<?php

namespace Openl10n\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Model\SecurityUser;
use Openl10n\Bundle\UserBundle\Entity\User as UserEntity;
use Openl10n\Domain\User\Repository\UserRepository as UserRepositoryInterface;
use Openl10n\Domain\User\Value\Username;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function createNew(Username $username)
    {
        return new UserEntity($username);
    }

    public function findOneByUsername(Username $username)
    {
        return $this->findOneBy(['username' => (string) $username]);
    }

    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush($user);
    }

    public function remove(User $user)
    {
        $this->_em->remove($user);
        $this->_em->flush($user);
    }
}
