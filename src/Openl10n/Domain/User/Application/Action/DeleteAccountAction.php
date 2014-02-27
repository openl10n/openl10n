<?php

namespace Openl10n\Domain\User\Application\Action;

use Openl10n\Domain\User\Model\User;

class DeleteAccountAction
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
