<?php

namespace Openl10n\Domain\User\Application\Action;

class RegisterUserAction
{
    public $username;
    public $displayName;
    public $email;
    public $password;
    public $preferedLocale = 'en';

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPreferedLocale()
    {
        return $this->preferedLocale;
    }

    public function setPreferedLocale($preferedLocale)
    {
        $this->preferedLocale = $preferedLocale;

        return $this;
    }
}
