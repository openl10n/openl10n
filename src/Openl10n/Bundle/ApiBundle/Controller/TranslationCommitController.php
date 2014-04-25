<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\Resource as ResourceFacade;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Openl10n\Domain\Translation\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Model\Resource;
use Openl10n\Value\String\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationCommitController extends Controller implements ClassResourceInterface
{
    /**
     * @Rest\View
     * @Rest\Get("/translation_commits/{source}/{target}")
     */
    public function cgetAction($project, $source, $target)
    {
        // TODO (?)
    }

    /**
     * @Rest\View
     * @Rest\Get("/translation_commits/{source}/{target}/{translation}")
     */
    public function getAction($project, $source, $target, $translation)
    {
        $project = $this->findProjectOr404($project);
        $translation = $this->get('openl10n.repository.translation')->findOneById($project, $translation);

        return new TranslationFacade($translation);
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

    protected function findTranslationOr404(Project $project, $id)
    {
        $translation = $this->get('openl10n.repository.translation')->findOneById($project, $id);

        if (null === $translation) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find translation with id %s',
                $id
            ));
        }

        return $translation;
    }
}
