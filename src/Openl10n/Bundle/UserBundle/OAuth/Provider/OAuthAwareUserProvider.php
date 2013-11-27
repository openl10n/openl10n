<?php

namespace Openl10n\Bundle\UserBundle\OAuth\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class OAuthAwareUserProvider implements OAuthAwareUserProviderInterface
{
    protected $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = null;

        // @TODO find user per provider ID
        if (null !== $email = $response->getEmail()) {
            $user = $this->manager->getRepository('Openl10nUserBundle:User')
                ->findOneBy(array('email' => $email))
            ;
        }

        if (null === $user) {
            // create this user on the fly
            $user = $this->createUser($response);

            $this->manager->persist($user);
            $this->manager->flush($user);
        }

        //throw new UsernameNotFoundException('You have not been allowed to access to this page.');

        return $user;
    }

    protected function createUser($response)
    {
        $username = $response->getUsername() ?: (new \DateTime())->getTimestamp();

        // TODO use proper factory service to create new user object
        $user = new User(new Slug($username));

        if (null !== $email = $response->getEmail()) {
            $user->setEmail(new Email($email));
        }

        if (null !== $name = $response->getRealName()) {
            $user->setDisplayName(new Name($name));
        }

        return $user;
    }
}
