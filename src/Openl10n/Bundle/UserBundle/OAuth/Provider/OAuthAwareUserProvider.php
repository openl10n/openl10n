<?php

namespace Openl10n\Bundle\UserBundle\OAuth\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Entity\User;
use Openl10n\Bundle\UserBundle\Entity\UserRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class OAuthAwareUserProvider implements AccountConnectorInterface, OAuthAwareUserProviderInterface
{
    protected $manager;
    protected $userRepository;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $this->manager->persist($user);
        $this->manager->flush($user);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = null;

        $providerName = $response->getResourceOwner()->getName();

        if (null !== $oauthId = $response->getUsername()) {
            $user = $this->manager->getRepository('Openl10nUserBundle:User')
                ->findOneByOAuthId($providerName, $oauthId)
            ;
        }

        if (null !== $user) {
            return $user;
        }

        if (null !== $email = $response->getEmail()) {
            $user = $this->manager->getRepository('Openl10nUserBundle:User')
                ->findOneBy(array('email' => $email))
            ;
        }

        if (null === $user) {
            throw new AccountNotLinkedException(sprintf("User '%s:%s' not found.", $providerName, $oauthId));
        }

        $this->attachOAuthId(
            $user,
            $response->getResourceOwner()->getName(),
            $response->getUsername()
        );

        $this->manager->persist($user);
        $this->manager->flush($user);

        return $user;
    }

    protected function attachOAuthId($user, $providerName, $oauthId)
    {
        if (null !== $oauthId) {
            $user->addOAuthTokenId($providerName, $oauthId);
        }
    }
}
