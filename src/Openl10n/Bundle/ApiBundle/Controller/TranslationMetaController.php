<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Openl10n\Bundle\ApiBundle\Facade\TranslationMeta as TranslationMetaFacade;
use Openl10n\Domain\Translation\Application\Action\EditTranslationMetaAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationMetaController extends BaseController
{
    /**
     * @ApiDoc(
     *     description="Get a translation",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\TranslationMeta"
     * )
     *
     * @Rest\View
     */
    public function getMetaAction($translation)
    {
        $translation = $this->findTranslationOr404($translation);

        return new TranslationMetaFacade($translation->getMeta());
    }

    /**
     * @ApiDoc(
     *     description="Edit the translation details",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" },
     *     },
     *     input={
     *         "class"="Openl10n\Bundle\InfraBundle\Form\Type\TranslationMetaType",
     *         "name"=""
     *     }
     * )
     *
     * @Rest\View
     */
    public function putMetaAction(Request $request, $translation)
    {
        $translation = $this->findTranslationOr404($translation);

        $action = new EditTranslationMetaAction($translation);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_translation_meta', $action);

        if ($form->submit($request->request->all(), false)->isValid()) {
            $this->get('openl10n.processor.edit_translation_meta')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }
}
