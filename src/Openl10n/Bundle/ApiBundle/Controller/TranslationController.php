<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\Resource as ResourceFacade;
use Openl10n\Bundle\ApiBundle\Facade\TranslationKey as TranslationKeyFacade;
use Openl10n\Bundle\ApiBundle\Facade\TranslationPhrase as TranslationPhraseFacade;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Resource\Application\Action\CreateResourceAction;
use Openl10n\Domain\Resource\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationController extends Controller implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function cgetAction()
    {
        // TODO (?) get all keys
    }

    /**
     * @Rest\View
     */
    public function getAction($translation)
    {
        $translation = $this->findTranslationOr404($translation);

        return new TranslationKeyFacade($translation);
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request, $project)
    {
        // TODO (?) create new key
    }

    /**
     * @Rest\View
     */
    public function cgetPhrasesAction(Request $request, $translation)
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
     * @Rest\View
     */
    public function getPhrasesAction(Request $request, $translation, $locale)
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
     * @Rest\View
     */
    public function putPhrasesAction(Request $request, $translation, $locale)
    {
        return $this->postPhrasesAction($request, $translation, $locale);
    }

    protected function findTranslationOr404($id)
    {
        $translation = $this->get('openl10n.repository.translation')->find($id);

        if (null === $translation) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find translation with id %s',
                $id
            ));
        }

        return $translation;
    }
}
