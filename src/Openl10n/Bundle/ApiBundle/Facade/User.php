<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use Openl10n\Domain\User\Model\User as UserModel;

class User
{
    public $username;
    public $name;
    public $email;

    public function __construct(UserModel $user)
    {
        $this->username = (string) $user->getUsername();
        $this->name = (string) $user->getName();
        $this->email = (string) $user->getEmail();
    }
}
