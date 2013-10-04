<?php

namespace Openl10n\Bundle\UserBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;

/**
 * User definition.
 */
interface UserInterface
{
    /**
     * User unique identifier.
     *
     * @return Slug Username
     */
    public function getUsername();

    /**
     * User display name.
     *
     * @return Name User display name
     */
    public function getDisplayName();

    /**
     * Update user name.
     *
     * @param Name $name User display name
     *
     * @return UserInterface
     */
    public function setDisplayName(Name $name);

    /**
     * User email.
     *
     * @return Email User email
     */
    public function getEmail();

    /**
     * Update email.
     *
     * @param Email $email User email
     *
     * @return UserInterface
     */
    public function setEmail(Email $email);

    /**
     * Get user prefered locale.
     *
     * @return Locale User prefered locale
     */
    public function getPreferedLocale();

    /**
     * Set user prefered locale.
     *
     * @param Locale $locale User prefered locale
     *
     * @return UserInterface
     */
    public function setPreferedLocale(Locale $locale);
}
