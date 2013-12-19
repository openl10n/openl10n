<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Openl10n\Bundle\CoreBundle\Action\ImportDomainAction;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\CoreBundle\Action\CreateProjectAction;
use Openl10n\Bundle\CoreBundle\Action\DeleteProjectAction;
use Openl10n\Bundle\CoreBundle\Action\EditProjectAction;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainController extends Controller implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function cgetAction($project)
    {
        $project = $this->findProjectOr404($project);
        $domains = $this->get('openl10n.repository.domain')->findByProject($project);

        return $domains;
    }

    /**
     * @Rest\View
     */
    public function getAction($project, $domain)
    {
        $project = $this->findProjectOr404($project);

        return $this->get('openl10n.repository.domain')->findOneBySlug($project, new Slug($domain));
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new ImportDomainAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_import_domain', $action, array(
            'csrf_protection' => false
        ));

        if ($form->handleRequest($request)->isValid()) {
            $domain = $this->get('openl10n.processor.import_domain')->execute($action);
            $url = $this->generateUrl(
                'openl10n_api_get_project_domain',
                array(
                    'project' => (string) $project->getSlug(),
                    'domain' => (string) $domain->getSlug(),
                ),
                true // absolute
            );

            return new Response('', 201, array('Location' => $url));
        }

        return View::create($form, 400);
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
