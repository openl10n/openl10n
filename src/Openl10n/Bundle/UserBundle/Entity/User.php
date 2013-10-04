<?php

namespace Openl10n\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Model\User as BaseUser;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

class User extends BaseUser implements SecurityUserInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var UserCredentials
     */
    protected $credentials;

    /**
     * @var array
     */
    private $roles;

    public function __construct(Slug $username)
    {
        parent::__construct($username);

        $this->roles = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        if (!$this->username instanceof Slug) {
            $this->username = new Slug($this->username);
        }

        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName()
    {
        if (!$this->displayName instanceof Name) {
            $this->displayName = new Name($this->displayName);
        }

        return $this->displayName;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        if (!$this->email instanceof Email) {
            $this->email = new Email($this->email);
        }

        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreferedLocale()
    {
        if (!$this->preferedLocale instanceof Locale) {
            $this->preferedLocale = new Locale($this->preferedLocale);
        }

        return $this->preferedLocale;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        if (null === $this->credentials) {
            return null;
        }

        return $this->credentials->getSalt();
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        if (null === $this->credentials) {
            return null;
        }

        return $this->credentials->getPassword();
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = clone $this->roles;
        $roles->add(new Role('ROLE_USER'));

        return $roles->toArray();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
}
