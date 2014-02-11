<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Domain\Translation\Application\Action\ExportTranslationFileAction;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportController extends Controller
{
    public function exportAction(Request $request, $project, $domain, $locale, $_format)
    {
        $project = $this->findProjectOr404($project);

        $action = new ExportTranslationFileAction($project);
        $form = $this->get('form.factory')->createNamed('', 'openl10n_export_domain', $action, array(
            'csrf_protection' => false
        ));

        $data = array(
            'locale' => $locale,
            'domain' => $domain,
            'format' => $_format,
        );

        if ($form->submit($data)->isValid()) {
            $file = $this->get('openl10n.processor.export_translation_file')->execute($action);

            return new BinaryFileResponse($file);
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
