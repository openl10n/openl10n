<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Openl10n\Bundle\ApiBundle\Facade\Resource as ResourceFacade;
use Openl10n\Bundle\ApiBundle\Facade\TranslationKey as TranslationKeyFacade;
use Openl10n\Domain\Resource\Application\Action\CreateResourceAction;
use Openl10n\Domain\Resource\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Resource\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Resource\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Model\Key;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class ResourceController extends BaseController implements ClassResourceInterface
{
    /**
     * Retrieve all the project resources.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="List all project resources",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when project does not exist"
     *     },
     *     requirements={
     *         { "name"="project", "dataType"="string", "required"=true, "description"="Project's slug" }
     *     }
     * )
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
     * Retrieve a resource by its id.
     *
     * @ApiDoc(
     *     description="Get a resource",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the resource with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="resource", "dataType"="integer", "required"=true, "description"="Resource's id" }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\Resource"
     * )
     * @Rest\View
     */
    public function getAction($resource)
    {
        $resource = $this->findResourceOr404($resource);

        return new ResourceFacade($resource);
    }

    /**
     * Create a new resource.
     *
     * @ApiDoc(
     *     description="Create a resource",
     *     statusCodes={
     *         201="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect"
     *     },
     *     parameters={
     *         { "name"="project", "dataType"="string", "required"="true" },
     *         { "name"="pathname", "dataType"="string", "required"="true" }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\Resource"
     * )
     * @Rest\View
     */
    public function cpostAction(Request $request)
    {
        $action = new CreateResourceAction();
        $form = $this->get('form.factory')->createNamed('', 'openl10n_create_resource', $action);

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
     * Update a resource.
     *
     * @ApiDoc(
     *     description="Update a resource",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when resource does not exist"
     *     },
     *     requirements={
     *         { "name"="resource", "dataType"="integer", "required"=true, "description"="Resource's id" }
     *     },
     *     input={
     *         "class"="Openl10n\Bundle\InfraBundle\Form\Type\UpdateResourceType",
     *         "name"=""
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\Resource"
     * )
     * @Rest\View
     */
    public function putAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $action = new UpdateResourceAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_update_resource', $action);

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
    public function deleteAction($resource)
    {
        // TODO
    }

    /**
     * Retrieve all the resource translations.
     *
     * @ApiDoc(
     *     description="List all resource translations",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when project does not exist"
     *     },
     *     requirements={
     *         { "name"="resource", "dataType"="integer", "required"=true, "description"="Resource's id" }
     *     }
     * )
     * @Rest\View
     */
    public function getTranslationsAction($resource)
    {
        $resource = $this->findResourceOr404($resource);

        $translations = $this->get('openl10n.repository.translation')->findByResource($resource);

        return (new ArrayCollection($translations))->map(function(Key $translation) {
            return new TranslationKeyFacade($translation);
        });
    }

    /**
     * Import translations from a resource
     *
     * @ApiDoc(
     *     description="Import a resource",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when resource does not exist"
     *     },
     *     requirements={
     *         { "name"="resource", "dataType"="integer", "required"=true, "description"="Resource's id" }
     *     },
     *     parameters={
     *         { "name"="locale", "dataType"="string", "required"="true" },
     *         { "name"="file", "dataType"="file", "required"="true" },
     *         { "name"="options", "dataType"="choice", "required"="false", "format"="{'reviewed':'Mark translations as reviewed', 'erase':'Erase same values', 'clean':'Clean unused values'}" }
     *     }
     * )
     * @Rest\Post
     * @Rest\View
     */
    public function importAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $action = new ImportTranslationFileAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_import_translation_file', $action);


        if ($form->handleRequest($request)->isValid()) {
            try {
                $this->get('openl10n.processor.import_translation_file')->execute($action);
            } catch (InvalidResourceException $e) {
                return $form->addError(new FormError($e->getMessage()));
            }

            return new Response('', 204);
        }

        return View::create($form, 400);
    }

    /**
     * Import translations from a resource
     *
     * @ApiDoc(
     *     description="Import a resource",
     *     statusCodes={
     *         204="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when resource does not exist"
     *     },
     *     requirements={
     *         { "name"="resource", "dataType"="integer", "required"=true, "description"="Resource's id" }
     *     },
     *     parameters={
     *         { "name"="locale", "dataType"="string", "required"="true" },
     *         { "name"="file", "dataType"="file", "required"="true" },
     *         { "name"="options", "dataType"="choice", "required"="false", "format"="{'reviewed':'Mark translations as reviewed', 'erase':'Erase same values', 'clean':'Clean unused values'}" }
     *     }
     * )
     * @Rest\View
     */
    public function putImportAction(Request $request, $resource)
    {
        return $this->importAction($request, $resource);
    }

    /**
     * Export translations from a resource
     *
     * @ApiDoc(
     *     description="Export a resource",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         400="Returned when data are incorrect",
     *         404="Returned when resource does not exist"
     *     },
     *     requirements={
     *         { "name"="resource", "dataType"="integer", "required"=true, "description"="Resource's id" }
     *     },
     *     filters={
     *         { "name"="locale", "dataType"="choice", "required"="true" },
     *         { "name"="format", "dataType"="choice", "required"="true", "format"="{'csv', 'ini', 'json', 'mo', 'php', 'po', 'ts', 'xlf', 'yml'}" },
     *         { "name"="options", "dataType"="choice", "required"="false", "format"="{'reviewed':'Mark translations as reviewed', 'erase':'Erase same values', 'clean':'Clean unused values'}" }
     *     }
     * )
     * @Rest\Get
     * @Rest\View
     */
    public function exportAction(Request $request, $resource)
    {
        $resource = $this->findResourceOr404($resource);

        $action = new ExportTranslationFileAction($resource);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_export_translation_file', $action);

        if ($form->submit($request->query->all())->isValid()) {
            $file = $this->get('openl10n.processor.export_translation_file')->execute($action);

            return new BinaryFileResponse($file);
        }

        return View::create($form, 400);
    }
}
