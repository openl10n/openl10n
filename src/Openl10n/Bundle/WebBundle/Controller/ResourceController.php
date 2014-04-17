<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\WebBundle\View\ResourceView;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Openl10n\Domain\Translation\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Translation\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Translation\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Model\Resource;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ResourceController extends Controller
{
    public function listAction($project)
    {
        $project = $this->findProjectOr404($project);

        $resources = $this->get('openl10n.repository.resource')->findByProject($project);
        $resources = array_map([$this, 'prepareResourceView'], $resources);

        usort($resources, function($res1, $res2) {
            return strcmp($res1->pathname, $res2->pathname);
        });

        return $this->render('Openl10nWebBundle:Resource:list.html.twig', array(
            'project' => $project,
            'resources' => $resources,
        ));
    }

    public function createAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new CreateResourceAction($project);
        $form = $this->createForm('openl10n_create_resource', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $resource = $this->get('openl10n.processor.create_resource')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_resource_list', array(
                'project' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Resource:create.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    public function updateAction(Request $request, $project, $resource)
    {
        $project = $this->findProjectOr404($project);
        $resource = $this->findResourceOr404($project, $resource);

        $action = new UpdateResourceAction($resource);
        $form = $this->createForm('openl10n_update_resource', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.update_resource')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_resource_list', array(
                'project' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Resource:update.html.twig', array(
            'project' => $project,
            'resource' => $this->prepareResourceView($resource),
            'form' => $form->createView(),
        ));
    }

    public function importAction(Request $request, $project, $resource)
    {
        $project = $this->findProjectOr404($project);
        $resource = $this->findResourceOr404($project, $resource);

        $action = new ImportTranslationFileAction($resource);
        $form = $this->createForm('openl10n_import_translation_file', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.import_translation_file')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_resource_list', array(
                'project' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Resource:import.html.twig', array(
            'project' => $project,
            'resource' => $this->prepareResourceView($resource),
            'form' => $form->createView(),
        ));
    }

    public function exportAction(Request $request, $project, $resource)
    {
        $project = $this->findProjectOr404($project);
        $resource = $this->findResourceOr404($project, $resource);

        $action = new ExportTranslationFileAction($resource);
        $form = $this->createForm('openl10n_export_translation_file', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $file = $this->get('openl10n.processor.export_translation_file')->execute($action);

            $response = new BinaryFileResponse($file);
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        }

        return $this->render('Openl10nWebBundle:Resource:export.html.twig', array(
            'project' => $project,
            'resource' => $this->prepareResourceView($resource),
            'form' => $form->createView(),
        ));
    }

    protected function findProjectOr404($slug)
    {
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw $this->createNotFoundException(sprintf('Unable to find project with slug "%s"', $slug));
        }

        return $project;
    }

    protected function findResourceOr404(Project $project, $hash)
    {
        $resource = $this->get('openl10n.repository.resource')->findOneByHash($project, $hash);

        if (null === $resource) {
            throw $this->createNotFoundException(sprintf('Unable to find resource with hash "%s"', $hash));
        }

        return $resource;
    }

    protected function prepareResourceView(Resource $resource)
    {
        $view = new ResourceView();
        $view->hash = (string) $resource->getHash();
        $view->pathname = (string) $resource->getPathname();

        return $view;
    }
}
