<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Openl10n\Domain\Project\Model\Language;
use FOS\RestBundle\View\View;

class RootController extends BaseController implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function indexAction()
    {
        return [
            'Hello' => 'world',
        ];
    }
}
