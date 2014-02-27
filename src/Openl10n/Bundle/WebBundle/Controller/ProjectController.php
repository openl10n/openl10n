<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\WebBundle\View\LanguageView;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Bundle\WebBundle\View\ProjectView;
use Openl10n\Domain\Project\Application\Action\CreateProjectAction;
use Openl10n\Domain\Project\Application\Action\DeleteProjectAction;
use Openl10n\Domain\Project\Application\Action\EditProjectAction;
use Openl10n\Domain\Project\Model\Language;
use Openl10n\Value\Localization\DisplayLocale;
use Openl10n\Value\Localization\RegionMap;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    public function listAction()
    {
        $projects = $this->get('openl10n.repository.project')->findAll();

        return $this->render('Openl10nWebBundle:Project:list.html.twig', array(
            'projects' => $projects,
        ));
    }

    public function showAction($slug)
    {
        $project = $this->findProjectOr404($slug);
        $languages = $this->get('openl10n.repository.language')->findByProject($project);

        // Prepare views
        $languages = array_map([$this, 'prepareLanguageView'], $languages);

        return $this->render('Openl10nWebBundle:Project:show.html.twig', array(
            'project' => $project,
            'languages' => $languages,
        ));
    }

    public function newAction(Request $request)
    {
        $action = new CreateProjectAction();
        $form = $this->createForm('openl10n_project', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $project = $this->get('openl10n.processor.create_project')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_project_show', array(
                'slug' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Project:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        $action = new EditProjectAction($project);
        $form = $this->createForm('openl10n_project', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.edit_project')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_project_show', array(
                'slug' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Project:edit.html.twig', array(
            'project' => $project,
            'form'    => $form->createView(),
        ));
    }

    public function deleteAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        // Create an empty form to only handle the CSRF token
        $form = $this->get('form.factory')->createBuilder('form')->getForm();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $action = new DeleteProjectAction($project);
            $this->get('openl10n.processor.delete_project')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_project_list'));
        }

        return $this->render('Openl10nWebBundle:Project:delete.html.twig', array(
            'project' => $project,
            'form'    => $form->createView(),
        ));
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

    protected function prepareProjectView(Project $project)
    {
        $view = new ProjectView();
        $view->name = (string) $project->getName();
        $view->slug = (string) $project->getSlug();

        return $view;
    }

    protected function prepareLanguageView(Language $language)
    {
        $locale = $language->getLocale();
        $displayLocale = DisplayLocale::createFromLocale($locale);

        $view = new LanguageView();
        $view->locale = (string) $locale;
        $view->name = (string) $displayLocale->getName();

        $view->flag = null !== $locale->getRegion() ?
            (string) $locale->getRegion() :
            RegionMap::$mapping[(string) $locale->getLanguage()];

        return $view;
    }
}
