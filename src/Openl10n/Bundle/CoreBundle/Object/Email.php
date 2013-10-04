<?php

namespace Openl10n\Bundle\CoreBundle\Object;

/**
 * Email value object.
 */
class Email
{
    /**
     * @var string
     */
    protected $email;

    /**
     * Build email object from string.
     *
     * @param string $email Email string representation
     *
     */
    public function __construct($email)
    {
        // @TODO email validation
        $this->email = $email;
    }

    /**
     * String representation of the email.
     *
     * @return string Representation of the email
     */
    public function toString()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
