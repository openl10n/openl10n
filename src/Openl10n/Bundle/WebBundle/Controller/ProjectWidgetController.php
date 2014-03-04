<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Domain\Project\Model\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectWidgetController extends Controller
{
    public function listDomainsAction(Project $project)
    {
        //$context = $this->get('openl10n.resolver.translation_context')->resolveContext($project);
        $domains = $this->get('openl10n.repository.domain')->findByProject($project);

        return $this->render('Openl10nWebBundle:ProjectWidget:listDomains.html.twig', array(
            'project' => $project,
            'domains' => $domains,
            //'context' => $context,
        ));
    }

    public function feedsAction(Project $project)
    {
        return $this->render('Openl10nWebBundle:ProjectWidget:feeds.html.twig', array(
        ));
    }

    public function statsAction(Project $project)
    {
        return $this->render('Openl10nWebBundle:ProjectWidget:stats.html.twig', array(
        ));
    }

    public function releasesAction(Project $project)
    {
        return $this->render('Openl10nWebBundle:ProjectWidget:releases.html.twig', array(
        ));
    }
}
