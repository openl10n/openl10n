<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Domain\Translation\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Translation\Application\Action\ImportTranslationFileAction;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DomainController extends Controller
{
    public function importAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        $action = new ImportTranslationFileAction($project);
        $form = $this->createForm('openl10n_import_domain', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $domain = $this->get('openl10n.processor.import_translation_file')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_project_show', array(
                'slug' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Domain:import.html.twig', array(
            'project' => $project,
            'form'    => $form->createView(),
        ));
    }

    public function exportAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        $action = new ExportTranslationFileAction($project);
        $form = $this->createForm('openl10n_export_domain', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $file = $this->get('openl10n.processor.export_translation_file')->execute($action);

            $response = new BinaryFileResponse($file);
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

            return $response;
        }

        return $this->render('Openl10nWebBundle:Domain:export.html.twig', array(
            'project' => $project,
            'form'    => $form->createView(),
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
}
