<?php

namespace Openl10n\Bundle\UserBundle\Action;

use Openl10n\Bundle\UserBundle\Model\UserInterface;

class DeleteUserAction
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
