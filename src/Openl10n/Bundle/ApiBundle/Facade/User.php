<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\User\Model\User as UserModel;

class User
{
    /**
     * @Serializer\Type("string")
     */
    public $username;

    /**
     * @Serializer\Type("string")
     */
    public $name;

    /**
     * @Serializer\Type("string")
     */
    public $email;

    public function __construct(UserModel $user)
    {
        $this->username = (string) $user->getUsername();
        $this->name = (string) $user->getName();
        $this->email = (string) $user->getEmail();
    }
}
