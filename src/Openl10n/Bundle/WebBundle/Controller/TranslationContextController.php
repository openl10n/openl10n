<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\InfraBundle\Action\SwitchTranslationContextAction;
use Openl10n\Bundle\InfraBundle\Object\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TranslationContextController extends Controller
{
    public function switchAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);

        $action = new SwitchTranslationContextAction($project);
        $form = $this->createForm('openl10n_translation_context', $action, array(
            'project' => $project,
        ));

        if ($form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.switch_translation_context')->execute($action);
        }

        return $this->redirect($this->generateUrl('openl10n_project_show', array(
            'slug' => $project->getSlug(),
        )));
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
