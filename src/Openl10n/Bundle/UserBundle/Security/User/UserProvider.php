<?php

namespace Openl10n\Bundle\UserBundle\Security\User;

use Openl10n\Domain\User\Value\Username;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    protected $userRepository;
    protected $credentialsRepository;

    public function __construct($userRepository, $credentialsRepository)
    {
        $this->userRepository = $userRepository;
        $this->credentialsRepository = $credentialsRepository;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->findOneByUsername(new Username($username));

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('Unable to find user "%s".', $username));
        }

        $credentials = $this->credentialsRepository->findOneByUser($user);

        return new User($user, $credentials);
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf(
                'Instances of "%s" are not supported.',
                $class
            ));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return 'Openl10n\\Bundle\\UserBundle\\Security\\User\\User';
    }
}
