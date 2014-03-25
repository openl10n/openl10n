<?php

namespace Openl10n\Bundle\EditorBundle\Controller;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TranslationController extends Controller
{
    public function listAction(Request $request, $project, $target)
    {
        $target = Locale::parse($target);

        $project = $this->findProjectOr404($project);
        //$domain = $this->findDomainOr404($project, $domain);
        $language = $this->findLanguageOr404($project, $target);

        $url = $this->generateUrl('openl10n_editor_translate', array(
            'project' => $project->getSlug(),
        ));

        // BackboneJS route
        $route = sprintf('%s/%s', $project->getDefaultLocale(), $target);

        return $this->redirect($url.'#'.$route);
    }

    public function showAction(Request $request, $project, $target, $hash)
    {
        $target = new Locale($target);

        $project = $this->findProjectOr404($project);
        //$domain = $this->findDomainOr404($project, $domain);
        $language = $this->findLanguageOr404($project, $target);
        $key = $this->findKeyOr404($project, $hash);

        $url = $this->generateUrl('openl10n_editor_translate', array(
            'project' => $project->getSlug(),
        ));

        // BackboneJS route
        $route = sprintf('%s/%s/%s', $project->getDefaultLocale(), $target, $hash);

        return $this->redirect($url.'#'.$route);
    }

    protected function findProjectOr404($slug)
    {
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw $this->createNotFoundException(sprintf('Unable to find project with slug "%s"', $slug));
        }

        return $project;
    }

    protected function findDomainOr404(Project $project, $slug)
    {
        $domain = $this->get('openl10n.repository.domain')->findOneBySlug($project, new Slug($slug));

        if (null === $domain) {
            throw $this->createNotFoundException(sprintf('Unable to find domain with slug "%s"', $slug));
        }

        return $domain;
    }

    protected function findLanguageOr404(Project $project, Locale $locale)
    {
        $language = $this->get('openl10n.repository.language')
            ->findOneByProject($project, $locale)
        ;

        if (null === $language) {
            throw $this->createNotFoundException(sprintf(
                'Project "%s" has no locale "%s"',
                $project->getSlug(),
                $locale
            ));
        }

        return $language;
    }

    protected function findKeyOr404(Project $project, $hash)
    {
        $key = $this->get('openl10n.repository.translation')->findOneByHash($project, $hash);

        if (null === $key) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find translation with hash "%s"',
                $hash
            ));
        }

        return $key;
    }
}
