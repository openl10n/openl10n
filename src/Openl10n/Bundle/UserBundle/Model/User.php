<?php

namespace Openl10n\Bundle\UserBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;

/**
 * User default implementation.
 */
class User implements UserInterface
{
    /**
     * @var Slug
     */
    protected $username;

    /**
     * @var Name
     */
    protected $displayName;

    /**
     * @var Email
     */
    protected $email;

    /**
     * @var Locale
     */
    protected $preferedLocale;

    /**
     * Build a User with a unique username.
     *
     * @param Slug $username The user username
     */
    public function __construct(Slug $username)
    {
        $this->username = $username;
        $this->preferedLocale = new Locale('en');
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayName(Name $name)
    {
        $this->displayName = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreferedLocale()
    {
        return $this->preferedLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function setPreferedLocale(Locale $locale)
    {
        $this->preferedLocale = $locale;

        return $this;
    }
}
