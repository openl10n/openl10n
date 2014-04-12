<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\WebBundle\View\DomainView;
use Openl10n\Bundle\WebBundle\View\ResourceView;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Domain;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectWidgetController extends Controller
{
    public function listDomainsAction(Project $project)
    {
        $domains = $this->get('openl10n.repository.domain')->findByProject($project);

        $resources = [];
        foreach ($domains as $domain) {
            $resources[] = $this->get('openl10n.repository.resource')->findByDomain($domain);
        }

        // Prepare views
        $domains = array_map([$this, 'prepareDomainView'], $domains, $resources);

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

    protected function prepareDomainView(Domain $domain, array $resources)
    {
        $view = new DomainView();
        $view->slug = (string) $domain->getSlug();
        $view->name = (string) $domain->getName();

        foreach ($resources as $resource) {
            $resView = new ResourceView();
            $resView->uuid = $resource->getUuid();
            $resView->pattern = $resource->getPattern();

            $view->resources[] = $resView;
        }

        return $view;
    }
}
