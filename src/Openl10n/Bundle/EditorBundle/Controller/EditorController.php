<?php

namespace Openl10n\Bundle\EditorBundle\Controller;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditorController extends Controller
{
    public function translateAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);
        $domains = $this->getProjectDomains($project);
        $languages = $this->getProjectLanguages($project);

        return $this->render('@Openl10nEditor/Editor/translate.html.twig', array(
            'project' => $project,
            'domains' => $domains,
            'languages' => $languages,
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

    protected function getProjectDomains(ProjectInterface $project)
    {
        return $this->get('openl10n.repository.domain')->findByProject($project);
    }

    protected function getProjectLanguages(ProjectInterface $project)
    {
        return $project->getLanguages();
    }
}
