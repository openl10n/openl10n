<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class TranslationMetaController extends BaseController
{
    /**
     * @Rest\View
     */
    public function getMetaAction($translation)
    {
        throw new \BadMethodCallException('Not implemented yet');
    }

    /**
     * @Rest\View
     */
    public function putMetaAction($translation)
    {
        throw new \BadMethodCallException('Not implemented yet');
    }
}
