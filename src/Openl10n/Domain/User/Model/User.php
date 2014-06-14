<?php

namespace Openl10n\Domain\User\Model;

use Openl10n\Domain\User\Value\Email;
use Openl10n\Domain\User\Value\Username;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;

class User
{
    /**
     * @var int
     */
    protected $id;

    protected $username;
    protected $email;
    protected $name;
    protected $preferedLocale;
    protected $credentials;

    public function __construct(Username $username)
    {
        $this->username = $username;
        $this->name = new Name($username);
        $this->preferedLocale = Locale::parse('en');
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(Email $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(Name $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getPreferedLocale()
    {
        return $this->preferedLocale;
    }

    public function setPreferedLocale(Locale $preferedLocale)
    {
        $this->preferedLocale = $preferedLocale;

        return $this;
    }

    public function getCredentials()
    {
        return $this->credentials;
    }
}
