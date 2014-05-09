<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\Resource as ResourceFacade;
use Openl10n\Bundle\ApiBundle\Facade\TranslationKey as TranslationKeyFacade;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Resource\Application\Action\CreateResourceAction;
use Openl10n\Domain\Resource\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Resource\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Resource\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourceController extends Controller implements ClassResourceInterface
{
    /**
     * @Rest\QueryParam(name="project", strict=true, nullable=false)
     * @Rest\View
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $project = $this->findProjectOr404($paramFetcher->get('project'));
        $resources = $this->get('openl10n.repository.resource')->findByProject($project);

        return (new ArrayCollection($resources))->map(function(Resource $resource) {
            return new ResourceFacade($resource);
        });
    }

    /**
     * @Rest\View
     */
    public function getAction($resource)
    {
        $resource = $this->findResourceOr404($resource);

        return new ResourceFacade($resource);
    }

    /**
     * @Rest\View
     */
    public function cpostAction(Request $request)
    {
        $action = new CreateResourceAction();
        $form = $this->get('form.factory')->createNamed('', 'openl10n_create_resource', $action, array(
            'csrf_protection' => false
        ));

        if ($form->handleRequest($request)->isValid()) {
            $resource = $this->get('openl10n.processor.create_resource')->execute($action);
            $facade = new ResourceFacade($resource);

            $url = $this->generateUrl(
                'openl10n_api_get_resource',
                ['resource' => $resource->getId()],
                true // absolute
            );

            return View::create($facade, 201, ['Location' => $url]);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function putAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $action = new UpdateResourceAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_update_resource', $action, array(
            'csrf_protection' => false
        ));

        if ($form->submit($request->request->all(), false)->isValid()) {
            $resource = $this->get('openl10n.processor.update_resource')->execute($action);
            $facade = new ResourceFacade($resource);

            return View::create($facade, 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(Request $request, $resource)
    {
        // TODO
    }

    /**
     * @Rest\View
     */
    public function getTranslationsAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $translations = $this->get('openl10n.repository.translation')->findByResource($resource);

        return (new ArrayCollection($translations))->map(function(Key $translation) {
            return new TranslationKeyFacade($translation);
        });
    }

    /**
     * @Rest\Post
     * @Rest\View
     */
    public function importAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $action = new ImportTranslationFileAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_import_translation_file', $action, array(
            'csrf_protection' => false
        ));

        if ($form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.import_translation_file')->execute($action);

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * @Rest\View
     */
    public function putImportAction(Request $request, $resource)
    {
        return $this->importAction($request, $resource);
    }

    /**
     * @Rest\Get
     * @Rest\View
     */
    public function exportAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $action = new ExportTranslationFileAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_export_translation_file', $action, array(
            'csrf_protection' => false
        ));

        if ($form->submit($request->query->all())->isValid()) {
            $file = $this->get('openl10n.processor.export_translation_file')->execute($action);

            return new BinaryFileResponse($file);
        }

        return View::create($form, 400);
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

    protected function findResourceOr404($id)
    {
        $resource = $this->get('openl10n.repository.resource')->find($id);

        if (null === $resource) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find resource with id %s',
                $id
            ));
        }

        return $resource;
    }
}
