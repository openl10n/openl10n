<?php

namespace Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\DeleteAccountAction;
use Openl10n\Domain\User\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteAccountProcessor
{
    protected $userRepository;
    protected $eventDispatcher;

    public function __construct(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(DeleteAccountAction $action)
    {
        $user = $action->getUser();

        $this->userRepository->remove($user);
    }
}
