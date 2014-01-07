<?php

namespace Openl10n\Bundle\UserBundle\Action;

use Openl10n\Bundle\UserBundle\Model\UserInterface;

class EditUserAction
{
    protected $user;

    public $username;
    public $displayName;
    public $email;
    public $preferedLocale;
    public $oldPassword;
    public $password;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->username = (string) $user->getUsername();
        $this->displayName = (string) $user->getDisplayName();
        $this->preferedLocale = (string) $user->getPreferedLocale();
        $this->email = (string) $user->getEmail();
    }

    public function getUser()
    {
        return $this->user;
    }
}
