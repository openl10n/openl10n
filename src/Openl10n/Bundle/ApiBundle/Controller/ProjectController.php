<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\CoreBundle\Action\CreateProjectAction;
use Openl10n\Bundle\CoreBundle\Action\DeleteProjectAction;
use Openl10n\Bundle\CoreBundle\Action\EditProjectAction;
use Openl10n\Bundle\CoreBundle\Object\Slug;
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

        return $projects;
    }

    /**
     * @Rest\View
     */
    public function getAction($slug)
    {
        return $this->findProjectOr404($slug);
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request)
    {
        $action = new CreateProjectAction();
        $form = $this->get('form.factory')->createNamed('', 'openl10n_project', $action, array(
            'csrf_protection' => false
        ));

        if ($form->handleRequest($request)->isValid()) {
            $project = $this->get('openl10n.processor.create_project')->execute($action);
            $url = $this->generateUrl(
                'openl10n_api_get_project',
                array('slug' => (string) $project->getSlug()),
                true // absolute
            );

            return new Response('', 201, array('Location' => $url));
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function putAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        $action = new EditProjectAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_project', $action, array(
            'csrf_protection' => false
        ));

        if ($form->submit($request->request->all())->isValid()) {
            $this->get('openl10n.processor.edit_project')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function patchAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        $action = new EditProjectAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_project', $action, array(
            'csrf_protection' => false
        ));

        if ($form->submit($request->request->all(), false)->isValid()) {
            $this->get('openl10n.processor.edit_project')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);
        $action = new DeleteProjectAction($project);
        $this->get('openl10n.processor.delete_project')->execute($action);
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
}
