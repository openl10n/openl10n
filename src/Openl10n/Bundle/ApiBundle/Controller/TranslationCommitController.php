<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\ApiBundle\Facade\TranslationCommit as TranslationCommitFacade;
use Openl10n\Bundle\EditorBundle\Translation\CustomTranslationSpecification;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Openl10n\Domain\Translation\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Resource;
use Openl10n\Value\Localization\Locale;
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
    public function cgetAction(Request $request, $project, $source, $target)
    {
        $source = Locale::parse($source);
        $target = Locale::parse($target);
        $project = $this->findProjectOr404($project);

        $specification = new CustomTranslationSpecification($project, $source, $target);

        // if ($request->query->has('domain')) {
        //     $specification->domain = $request->query->get('domain');
        // }
        // if ($request->query->has('translated')) {
        //     $specification->translated = $request->query->get('translated');
        // }
        // if ($request->query->has('approved')) {
        //     $specification->approved = $request->query->get('approved');
        // }
        // if ($request->query->has('text')) {
        //     $specification->text = $request->query->get('text');
        // }

        $pager = $this->get('openl10n.repository.translation')->findSatisfying($specification);
        $pager->setMaxPerPage(1000);

        try {
            $pager->setCurrentPage($request->query->get('page', 1));

            $results = iterator_to_array($pager->getCurrentPageResults());
        } catch (OutOfRangeCurrentPageException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return (new ArrayCollection($results))->map(function(Key $key) use ($source, $target) {
            return new TranslationCommitFacade($key, $source, $target);
        });
    }

    /**
     * @Rest\View
     * @Rest\Get("/translation_commits/{source}/{target}/{translation}")
     */
    public function getAction($project, $source, $target, $translation)
    {
        $project = $this->findProjectOr404($project);
        $translation = $this->get('openl10n.repository.translation')->findOneById($project, $translation);

        $source = Locale::parse($source);
        $target = Locale::parse($target);

        return new TranslationCommitFacade($translation, $source, $target);
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
