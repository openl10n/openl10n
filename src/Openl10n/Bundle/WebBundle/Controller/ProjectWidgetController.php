<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\WebBundle\View\DomainView;
use Openl10n\Bundle\WebBundle\View\ResourceView;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Domain\Resource\Model\Resource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProjectWidgetController extends Controller
{
    public function resourcesAction(Project $project)
    {
        $resources = $this->get('openl10n.repository.resource')->findByProject($project);

        // Prepare views
        $resources = array_map([$this, 'prepareResourceView'], $resources);

        return $this->render('Openl10nWebBundle:ProjectWidget:resources.html.twig', array(
            'project' => $project,
            'resources' => $resources,
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

    protected function prepareResourceView(Resource $resource)
    {
        $view = new ResourceView();
        $view->hash = (string) $resource->getHash();
        $view->pathname = (string) $resource->getPathname();

        return $view;
    }
}
