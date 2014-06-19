<?php

namespace Openl10n\Domain\User\Model;

class Credentials
{
    /**
     * @var int
     */
    protected $id;

    protected $user;
    protected $password;
    protected $salt;

    /**
     * @param User   $user
     * @param string $password
     * @param string $salt
     */
    public function __construct(User $user, $password, $salt)
    {
        $this->user = $user;
        $this->password = $password;
        $this->salt = $salt;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }
}
