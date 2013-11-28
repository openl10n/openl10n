<?php

namespace Openl10n\Bundle\UserBundle\Entity;

use Openl10n\Bundle\UserBundle\Model\UserInterface;

class UserOAuthToken
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $providerName;

    /**
     * @var string
     */
    protected $tokenId;

    /**
     * @param UserInterface $user
     * @param string        $providerName
     * @param string        $tokenId
     */
    public function __construct(UserInterface $user, $providerName, $tokenId)
    {
        $this->user = $user;
        $this->providerName = $providerName;
        $this->tokenId = $tokenId;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getProviderName()
    {
        return $this->providerName;
    }

    public function getTokenId()
    {
        return $this->tokenId;
    }
}
