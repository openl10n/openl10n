<?php

namespace Openl10n\Bundle\UserBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

class RegisterUser implements UserInterface
{
    public $username;
    public $displayName;
    public $email;

    public function getRoles()
    {
        return array();
    }

    public function getPassword()
    {
        return '';
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        return;
    }
}
