<?php

namespace Openl10n\Bundle\UserBundle\Entity;

use Openl10n\Bundle\UserBundle\Model\UserInterface;

class UserCredentials
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @param UserInterface $user
     * @param string        $password
     * @param string        $salt
     */
    public function __construct(UserInterface $user, $password, $salt)
    {
        $this->user = $user;
        $this->password = $password;
        $this->salt = $salt;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
