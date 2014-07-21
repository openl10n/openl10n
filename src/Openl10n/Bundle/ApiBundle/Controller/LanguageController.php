<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Openl10n\Domain\Project\Model\Language;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\Language as LanguageFacade;
use Openl10n\Domain\Project\Application\Action\CreateLanguageAction;
use Openl10n\Domain\Project\Application\Action\DeleteLanguageAction;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\Localization\Locale;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageController extends BaseController implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function cgetAction($project)
    {
        $project = $this->findProjectOr404($project);
        $languages = $this->get('openl10n.repository.language')->findByProject($project);

        $facades = array_map([$this, 'transformLanguage'], $languages);

        return $facades;
    }

    /**
     * @Rest\View
     */
    public function getAction($project, $locale)
    {
        $project = $this->findProjectOr404($project);
        $language = $this->findLanguageOr404($project, $locale);

        $facade = $this->transformLanguage($language);

        return $facade;
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new CreateLanguageAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_language', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $language = $this->get('openl10n.processor.create_language')->execute($action);
            $url = $this->generateUrl(
                'openl10n_api_get_project_language',
                array(
                    'project' => (string) $project->getSlug(),
                    'locale' => (string) $language->getLocale(),
                ),
                true // absolute
            );

            return new Response('', 201, array('Location' => $url));
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction($project, $locale)
    {
        $project = $this->findProjectOr404($project);
        $language = $this->findLanguageOr404($project, $locale);

        if ((string) $project->getDefaultLocale() === (string) Locale::parse($locale)) {
            return View::create(array(
                'message' => 'You can not delete project default locale'
            ), 400);
        }

        $action = new DeleteLanguageAction($language);
        $this->get('openl10n.processor.delete_language')->execute($action);
    }

    protected function transformLanguage(Language $language)
    {
        $facade = new LanguageFacade($language);

        return $facade;
    }
}
