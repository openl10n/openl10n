<?php

namespace Openl10n\Bundle\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function findOneByEmail(Email $email)
    {
        return $this->findOneBy(array('email' => (string) $email));
    }

    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->select('u, c, r')
            ->leftJoin('u.credentials', 'c')
            ->leftJoin('u.roles', 'r')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AcmeUserBundle:User object identified by "%s".',
                $username
            );

            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function findOneByOAuthId($providerName, $tokenId)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->select('u, t, u')
            ->leftJoin('u.oauthTokens', 't')
            ->leftJoin('u.roles', 'r')
            ->where('t.providerName = :providerName')
            ->andWhere('t.tokenId = :tokenId')
            ->setParameter('providerName', $providerName)
            ->setParameter('tokenId', $tokenId)
            ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $user;
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

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }
}
