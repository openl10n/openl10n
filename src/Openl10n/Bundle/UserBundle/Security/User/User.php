<?php

namespace Openl10n\Bundle\UserBundle\Security\User;

use Openl10n\Domain\User\Model\Credentials;
use Openl10n\Domain\User\Model\User as UserModel;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    protected $user;
    protected $password;
    protected $salt;

    public function __construct(UserModel $user, Credentials $credentials)
    {
        $this->user = $user;
        $this->password = $credentials->getPassword();
        $this->salt = $credentials->getSalt();
    }

    /**
     * Get wrapped user instance.
     *
     * @return UserModel The user as defined in the Domain
     */
    public function getOriginalUser()
    {
        return $this->user;
    }

    public function getUsername()
    {
        return (string) $this->user->getUsername();
    }

    public function getDisplayName()
    {
        return $this->user->getName();
    }

    public function getEmail()
    {
        return $this->user->getEmail();
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function eraseCredentials()
    {
        //$this->password = '';
        //$this->salt = '';
    }
}
