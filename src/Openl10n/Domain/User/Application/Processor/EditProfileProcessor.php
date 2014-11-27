<?php

namespace Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\EditProfileAction;
use Openl10n\Value\Localization\Locale;
use Openl10n\Domain\User\Value\Email;
use Openl10n\Value\String\Name;
use Openl10n\Domain\User\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditProfileProcessor
{
    protected $userRepository;
    protected $eventDispatcher;

    public function __construct(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(EditProfileAction $action)
    {
        $user = $action->getUser();

        $user
            ->setName(new Name($action->getDisplayName()))
            ->setEmail(new Email($action->getEmail()))
            ->setPreferredLocale(Locale::parse($action->getPreferredLocale()))
        ;

        $this->userRepository->save($user);
    }

}
