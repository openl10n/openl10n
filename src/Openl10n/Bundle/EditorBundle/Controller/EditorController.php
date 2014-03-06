<?php

namespace Openl10n\Bundle\EditorBundle\Controller;

use Openl10n\Bundle\WebBundle\View\LanguageView;
use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\Localization\DisplayLocale;
use Openl10n\Value\Localization\RegionMap;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditorController extends Controller
{
    public function translateAction(Request $request, $project)
    {
        $project = $this->findProjectOr404($project);
        $appData = $this->getDataForProject($project);

        $languages = array_map(
            [$this, 'prepareLanguageView'],
            $this->get('openl10n.repository.language')->findByProject($project)
        );

        $domains = $this->get('openl10n.repository.domain')->findByProject($project);

        return $this->render('@Openl10nEditor/Editor/translate.html.twig', array(
            'project' => $project,
            'languages' => $languages,
            'domains' => $domains,
            'data' => $appData,
        ));
    }

    protected function getDataForProject(Project $project)
    {
        $data = array();

        $data['project'] = array(
            'id' => (string) $project->getSlug(),
            'name' => (string) $project->getName(),
            'locale' => (string) $project->getDefaultLocale(),
        );

        $data['domains'] = array();
        foreach ($this->getProjectDomains($project) as $domain) {
            $data['domains'][] = array(
                'id' => (string) $domain->getSlug(),
                'name' => (string) $domain->getName(),
            );
        }

        $data['languages'] = array();
        foreach ($this->getProjectLanguages($project) as $language) {
            $locale = $language->getLocale();
            $displayLocale = DisplayLocale::createFromLocale($locale);
            $data['languages'][] = array(
                'id' => (string) $locale,
                'name' => (string) $displayLocale->getName(),
            );
        }

        return $data;
    }

    protected function findProjectOr404($slug)
    {
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw $this->createNotFoundException(sprintf('Unable to find project with slug "%s"', $slug));
        }

        return $project;
    }

    protected function getProjectDomains(Project $project)
    {
        return $this->get('openl10n.repository.domain')->findByProject($project);
    }

    protected function getProjectLanguages(Project $project)
    {
        return $this->get('openl10n.repository.language')->findByProject($project);
    }

    protected function prepareLanguageView(Language $language)
    {
        $locale = $language->getLocale();
        $displayLocale = DisplayLocale::createFromLocale($locale);

        $view = new LanguageView();
        $view->locale = (string) $locale;
        $view->name = (string) $displayLocale->getName();

        $view->flag = null !== $locale->getRegion() ?
            (string) $locale->getRegion() :
            RegionMap::$mapping[(string) $locale->getLanguage()];

        return $view;
    }
}
