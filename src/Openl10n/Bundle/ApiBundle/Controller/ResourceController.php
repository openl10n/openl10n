<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\Resource as ResourceFacade;
use Openl10n\Bundle\ApiBundle\Facade\TranslationKey as TranslationKeyFacade;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Openl10n\Domain\Translation\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Resource;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller implements ClassResourceInterface
{
    /**
     * @Rest\View
     */
    public function cgetAction($project)
    {
        $project = $this->findProjectOr404($project);
        $resources = $this->get('openl10n.repository.resource')->findByProject($project);

        return (new ArrayCollection($resources))->map(function(Resource $resource) {
            return new ResourceFacade($resource);
        });
    }

    /**
     * @Rest\View
     */
    public function getAction($project, $resource)
    {
        $project = $this->findProjectOr404($project);
        $resource = $this->get('openl10n.repository.resource')->findOneById($project, $resource);

        return new ResourceFacade($resource);
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new CreateResourceAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_create_resource', $action, array(
            'csrf_protection' => false
        ));

        if ($form->handleRequest($request)->isValid()) {
            $resource = $this->get('openl10n.processor.create_resource')->execute($action);
            $url = $this->generateUrl(
                'openl10n_api_get_project_resource',
                array(
                    'project' => (string) $project->getSlug(),
                    'resource' => $resource->getId(),
                ),
                true // absolute
            );

            return new Response('', 201, array('Location' => $url));
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function putAction(Request $request, $project, $resource)
    {
        $project = $this->findProjectOr404($project);
        $resource = $this->findResourceOr404($project, $resource);

        $action = new UpdateResourceAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_update_resource', $action, array(
            'csrf_protection' => false
        ));

        if ($form->submit($request->request->all(), false)->isValid()) {
            $resource = $this->get('openl10n.processor.update_resource')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(Request $request, $project, $resource)
    {
        // TODO
    }

    /**
     * @Rest\View
     */
    public function getTranslationsAction(Request $request, $project, $resource)
    {
        $project = $this->findProjectOr404($project);
        $resource = $this->findResourceOr404($project, $resource);

        $translations = $this->get('openl10n.repository.translation')->findByResource($resource);

        return (new ArrayCollection($translations))->map(function(Key $translation) {
            return new TranslationKeyFacade($translation);
        });
    }

    /**
     * @Rest\View
     */
    public function putImportAction(Request $request, $project, $resource)
    {
        // TODO
    }

    /**
     * @Rest\View
     */
    public function getExportAction(Request $request, $project, $resource)
    {
        // TODO
    }

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

    protected function findResourceOr404(Project $project, $id)
    {
        $resource = $this->get('openl10n.repository.resource')->findOneById($project, $id);

        if (null === $resource) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find resource with id %s',
                $id
            ));
        }

        return $resource;
    }
}
