<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class BaseController extends Controller
{
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

    /**
     * @return Language
     */
    protected function findLanguageOr404(Project $project, $locale)
    {
        $language = $this->get('openl10n.repository.language')
            ->findOneByProject($project, Locale::parse($locale))
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

    /**
     * @return Resource
     */
    protected function findResourceOr404($id)
    {
        $resource = $this->get('openl10n.repository.resource')->find($id);

        if (null === $resource) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find resource with id %s',
                $id
            ));
        }

        return $resource;
    }

    /**
     * @param int $id Translation id.
     *
     * @return Key The translation key
     *
     * @throws NotFoundHttpException If the project is not found
     */
    protected function findTranslationOr404($id)
    {
        $translation = $this->get('openl10n.repository.translation')->findOneById($id);

        if (null === $translation) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find translation with id %s',
                $id
            ));
        }

        return $translation;
    }
}
