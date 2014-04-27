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
use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Domain\Translation\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Model\Resource;
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
    public function cgetAction($project)
    {
        // TODO (?) get all keys
    }

    /**
     * @Rest\View
     */
    public function getAction($project, $translation)
    {
        $project = $this->findProjectOr404($project);
        $translation = $this->findTranslationOr404($project, $translation);

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
    public function cgetPhrasesAction(Request $request, $project, $translation)
    {
        $project = $this->findProjectOr404($project);
        $translation = $this->findTranslationOr404($project, $translation);

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
    public function getPhrasesAction(Request $request, $project, $translation, $locale)
    {
        $project = $this->findProjectOr404($project);
        $translation = $this->findTranslationOr404($project, $translation);

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
    public function postPhrasesAction(Request $request, $project, $translation, $locale)
    {
        $project = $this->findProjectOr404($project);
        $translation = $this->findTranslationOr404($project, $translation);
        $locale = Locale::parse($locale);

        $action = new EditTranslationPhraseAction($translation, $locale);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_translation', $action, array(
            'csrf_protection' => false
        ));

        if ($form->submit($request->request->all())->isValid()) {
            $this->get('openl10n.processor.edit_translation')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function putPhrasesAction(Request $request, $project, $translation, $locale)
    {
        return $this->postPhrasesAction($request, $project, $translation, $locale);
    }

    /**
     * Find a project by its slug.
     *
     * @param string $slug The project slug
     *
     * @return ProjectInterface The project
     *
     * @throws NotFoundHttpException If the project is not found
     */
    protected function findProjectOr404($slug)
    {
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find project with slug "%s"',
                $slug
            ));
        }

        return $project;
    }

    protected function findTranslationOr404(Project $project, $id)
    {
        $translation = $this->get('openl10n.repository.translation')->findOneById($project, $id);

        if (null === $translation) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find translation with id %s',
                $id
            ));
        }

        return $translation;
    }
}
