<?php

namespace Openl10n\Domain\User\Application\Action;

use Openl10n\Domain\User\Model\User;

class EditProfileAction
{
    protected $user;

    protected $displayName;
    protected $preferredLocale;
    protected $email;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->displayName = $user->getName();
        $this->preferredLocale = $user->getPreferredLocale();
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

    public function getPreferredLocale()
    {
        return $this->preferredLocale;
    }

    public function setPreferredLocale($preferredLocale)
    {
        $this->preferredLocale = $preferredLocale;

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
