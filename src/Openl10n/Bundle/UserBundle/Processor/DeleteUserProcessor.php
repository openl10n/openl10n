<?php

namespace Openl10n\Bundle\UserBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\UserBundle\Action\DeleteUserAction;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteUserProcessor
{
    protected $userManager;

    public function __construct(
        ObjectManager $userManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->userManager = $userManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(DeleteUserAction $action)
    {
        $user = $action->getUser();

        $credentials = $user->getCredentials();
        $this->userManager->remove($credentials);

        foreach ($user->getRoles() as $role) {
            if ('ROLE_USER' !== $role->getRole()) {
                $this->userManager->remove($role);
            }
        }

        $this->userManager->remove($user);
        $this->userManager->flush($user);
    }
}
