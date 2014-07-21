<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\User as UserFacade;

class MeController extends BaseController
{
    /**
     * @Rest\View
     */
    public function indexAction()
    {
        $user = $this->getUser()->getOriginalUser();

        return new UserFacade($user);
    }
}
