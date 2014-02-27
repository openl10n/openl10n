<?php

namespace Openl10n\Domain\User\Application\Action;

use Openl10n\Domain\User\Model\User;

class EditProfileAction
{
    protected $user;

    protected $displayName;
    protected $preferedLocale;
    protected $email;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->displayName = $user->getName();
        $this->preferedLocale = $user->getPreferedLocale();
        $this->email = $user->getEmail();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

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

    public function getPreferedLocale()
    {
        return $this->preferedLocale;
    }

    public function setPreferedLocale($preferedLocale)
    {
        $this->preferedLocale = $preferedLocale;

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
}
