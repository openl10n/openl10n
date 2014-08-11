<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Openl10n\Bundle\ApiBundle\Facade\TranslationKey as TranslationKeyFacade;
use Openl10n\Bundle\ApiBundle\Facade\TranslationPhrase as TranslationPhraseFacade;
use Openl10n\Bundle\InfraBundle\Specification\TranslationByProjectSpecification;
use Openl10n\Domain\Translation\Application\Action\CreateTranslationKeyAction;
use Openl10n\Domain\Translation\Application\Action\DeleteTranslationKeyAction;
use Openl10n\Domain\Translation\Application\Action\DeleteTranslationPhraseAction;
use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Value\Localization\Locale;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationController extends BaseController implements ClassResourceInterface
{
    /**
     * Retrieve all the project's translations.
     *
     * @ApiDoc(
     *     description="List the translations",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the project with given id does not exist"
     *     }
     * )
     *
     * @Rest\QueryParam(name="project", strict=true, nullable=false)
     * @Rest\View
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $project = $this->findProjectOr404($paramFetcher->get('project'));

        $specification = new TranslationByProjectSpecification($project);

        $pager = $this->get('openl10n.repository.translation')->findSatisfying($specification);
        $pager->setMaxPerPage(10000);

        $translations = iterator_to_array($pager->getIterator());

        return (new ArrayCollection($translations))->map(function(Key $translation) {
            return new TranslationKeyFacade($translation, true);
        });
    }

    /**
     * Retrieve a translation by its id.
     *
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
     *     output="Openl10n\Bundle\ApiBundle\Facade\TranslationKey"
     * )
     * @Rest\View
     */
    public function getAction($translation)
    {
        $translation = $this->findTranslationOr404($translation);

        $facade = new TranslationKeyFacade($translation);
        $facade->phrases = [];

        foreach ($translation->getPhrases() as $phrase) {
            $locale = (string) $phrase->getLocale();
            $facade->phrases[$locale] = new TranslationPhraseFacade($phrase);
        }

        return $facade;
    }

    /**
     * Create a new translation.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Create a translation",
     *     statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect"
     *     },
     *     parameters={
     *         { "name"="resource", "dataType"="integer", "required"="true", "description"="Resource's id" },
     *         { "name"="identifier", "dataType"="string", "required"="true", "description"="Translation's key" }
     *     },
     *     output={
     *         "class"="Openl10n\Bundle\ApiBundle\Facade\TranslationKey",
     *         "groups"={"item"}
     *     }
     * )
     * @Rest\View
     */
    public function cpostAction(Request $request)
    {
        $action = new CreateTranslationKeyAction();
        $form = $this->get('form.factory')->createNamed('', 'openl10n_create_translation_key', $action);

        if ($form->handleRequest($request)->isValid()) {
            $translation = $this->get('openl10n.processor.create_translation_key')->execute($action);
            $facade = new TranslationKeyFacade($translation);

            $url = $this->generateUrl(
                'openl10n_api_get_translation',
                ['translation' => $translation->getId()],
                true // absolute
            );

            return View::create($facade, 201, ['Location' => $url]);
        }

        return View::create($form, 400);
    }

    /**
     * Delete a translation.
     *
     * @ApiDoc(
     *     description="Delete a translation",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" }
     *     }
     * )
     * @Rest\View(statusCode=204)
     */
    public function deleteAction($translation)
    {
        $translationKey = $this->findTranslationOr404($translation);
        $action = new DeleteTranslationKeyAction($translationKey);
        $this->get('openl10n.processor.delete_translation_key')->execute($action);
    }

    /**
     * Retrieve all the translation phrases.
     *
     * @ApiDoc(
     *     description="List all translation phases",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\TranslationKey"
     * )
     * @Rest\View
     */
    public function cgetPhrasesAction($translation)
    {
        $translation = $this->findTranslationOr404($translation);

        $facade = [];

        foreach ($translation->getPhrases() as $phrase) {
            $locale = (string) $phrase->getLocale();
            $facade[$locale] = new TranslationPhraseFacade($phrase);
        }

        return $facade;
    }

    /**
     * Retrieve a translation phrase by its locale.
     *
     * @ApiDoc(
     *     description="Get a translation phrase",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" },
     *         { "name"="locale", "dataType"="string", "required"=true }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\TranslationPhrase"
     * )
     * @Rest\View
     */
    public function getPhrasesAction($translation, $locale)
    {
        $translation = $this->findTranslationOr404($translation);

        $phrase = $translation->getPhrase(Locale::parse($locale));

        if (null === $phrase) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find phrase for translation %s with locale %s',
                $translation->getId(),
                $locale
            ));
        }

        return new TranslationPhraseFacade($phrase);
    }

    /**
     * Create a translation phrase.
     *
     * @ApiDoc(
     *     description="Create a translation phrase",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" },
     *         { "name"="locale", "dataType"="string", "required"=true }
     *     },
     *     input={
     *         "class"="Openl10n\Bundle\InfraBundle\Form\Type\TranslationType",
     *         "name"=""
     *     }
     * )
     * @Rest\View
     */
    public function postPhrasesAction(Request $request, $translation, $locale)
    {
        $translation = $this->findTranslationOr404($translation);
        $locale = Locale::parse($locale);

        $action = new EditTranslationPhraseAction($translation, $locale);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_translation', $action);

        if ($form->submit($request->request->all(), false)->isValid()) {
            $this->get('openl10n.processor.edit_translation')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * Update a translation phrase.
     *
     * @ApiDoc(
     *     description="Update a translation phrase",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" },
     *         { "name"="locale", "dataType"="string", "required"=true }
     *     },
     *     input={
     *         "class"="Openl10n\Bundle\InfraBundle\Form\Type\TranslationType",
     *         "name"=""
     *     }
     * )
     * @Rest\View
     */
    public function putPhrasesAction(Request $request, $translation, $locale)
    {
        return $this->postPhrasesAction($request, $translation, $locale);
    }

    /**
     * Delete a translation phrase.
     *
     * @ApiDoc(
     *     description="Delete a translation phrase",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when translation or phrase does not exist"
     *     },
     *     requirements={
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" },
     *         { "name"="locale", "dataType"="string", "required"=true }
     *     },
     * )
     * @Rest\View(statusCode=204)
     */
    public function deletePhrasesAction($translation, $locale)
    {
        $translationKey = $this->findTranslationOr404($translation);
        $translationPhrase = $translationKey->getPhrase(Locale::parse($locale));

        if (null === $translationPhrase) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find a "%s" phrase for translation #%s',
                $locale,
                $translationKey->getId()
            ));
        }

        $action = new DeleteTranslationPhraseAction($translationPhrase);
        $this->get('openl10n.processor.delete_translation_phrase')->execute($action);
    }
}
