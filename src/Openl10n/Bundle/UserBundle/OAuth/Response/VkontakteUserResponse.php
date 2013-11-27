<?php

namespace Openl10n\Bundle\UserBundle\OAuth\Response;

use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;

class VkontakteUserResponse extends PathUserResponse
{
    public function getEmail()
    {
        return 'foobar@vk.com';
    }
}
