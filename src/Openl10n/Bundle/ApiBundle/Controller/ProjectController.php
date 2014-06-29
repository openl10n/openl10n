<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\Project as ProjectFacade;
use Openl10n\Domain\Project\Application\Action\CreateProjectAction;
use Openl10n\Domain\Project\Application\Action\DeleteProjectAction;
use Openl10n\Domain\Project\Application\Action\EditProjectAction;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function cgetAction()
    {
        $projects = $this->get('openl10n.repository.project')->findAll();

        $facades = array_map([$this, 'transformProject'], $projects);

        return $facades;
    }

    /**
     * @Rest\View
     */
    public function getAction($project)
    {
        $project = $this->findProjectOr404($project);

        $facade = $this->transformProject($project);

        return $facade;
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request)
    {
        $action = new CreateProjectAction();
        $form = $this->get('form.factory')->createNamed('', 'openl10n_project', $action);

        if ($form->handleRequest($request)->isValid()) {
            $project = $this->get('openl10n.processor.create_project')->execute($action);
            $facade = new ProjectFacade($project);

            $url = $this->generateUrl(
                'openl10n_api_get_project',
                array('project' => (string) $project->getSlug()),
                true // absolute
            );

            return View::create($facade, 201, ['Location' => $url]);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function putAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new EditProjectAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_project', $action);

        if ($form->submit($request->request->all())->isValid()) {
            $this->get('openl10n.processor.edit_project')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function patchAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new EditProjectAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_project', $action);

        if ($form->submit($request->request->all(), false)->isValid()) {
            $this->get('openl10n.processor.edit_project')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);
        $action = new DeleteProjectAction($project);
        $this->get('openl10n.processor.delete_project')->execute($action);
    }

    /**
     * Find a project by its slug.
     *
     * @param string $slug The project slug
     *
     * @return Project The project
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

    protected function transformProject(Project $project)
    {
        $facade = new ProjectFacade($project);

        return $facade;
    }
}
