<?php

namespace Openl10n\Bundle\UserBundle\Twig\Extension;

class UserExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            'avatar_url' => new \Twig_Function_Method($this, 'getAvatarUrl'),
        );
    }

    public function getAvatarUrl($email, $size = 80)
    {
        return sprintf(
            'http://www.gravatar.com/avatar/%s?d=%s&s=%s&r=%s',
            md5(strtolower(trim($email))),
            'identicon',
            $size,
            'G'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}
