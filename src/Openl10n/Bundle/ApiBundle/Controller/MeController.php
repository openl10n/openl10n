<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Openl10n\Bundle\ApiBundle\Facade\User as UserFacade;

class MeController extends BaseController
{
    /**
     * Retrieve the authenticated user.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Get authenticated user",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized"
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\User"
     * )
     * @Rest\View
     */
    public function indexAction()
    {
        $user = $this->getUser()->getOriginalUser();

        return new UserFacade($user);
    }
}
