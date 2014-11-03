<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Openl10n\Domain\Project\Model\Language;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Openl10n\Bundle\ApiBundle\Facade\Language as LanguageFacade;
use Openl10n\Value\Localization\Locale;

class LanguageController extends BaseController implements ClassResourceInterface
{
    /**
     * Retrieve all the project languages.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="List all project languages",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when project does not exist"
     *     }
     * )
     * @Rest\View
     */
    public function cgetAction()
    {
        $locales = $this->get('openl10n.repository.locale')->findAll();
        $facades = array_map([$this, 'transformLanguage'], $locales);

        return $facades;
    }

    /**
     * Retrieve a project language by its locale.
     *
     * @ApiDoc(
     *     description="Get a project language",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when project or locale does not exist"
     *     },
     *     requirements={
     *         { "name"="locale", "dataType"="string", "required"=true, "description"="Language's locale" }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\Language"
     * )
     * @Rest\View
     */
    public function getAction($locale)
    {
        $facade = $this->transformLanguage($locale);

        return $facade;
    }

    protected function transformLanguage($locale)
    {
        $facade = new LanguageFacade(Locale::parse($locale));

        return $facade;
    }
}
