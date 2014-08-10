<?php

namespace Openl10n\Bundle\ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Openl10n\Bundle\ApiBundle\Facade\TranslationCommit as TranslationCommitFacade;
use Openl10n\Bundle\InfraBundle\Specification\CustomTranslationSpecification;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Value\Localization\Locale;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Component\HttpFoundation\Request;

class TranslationCommitController extends BaseController implements ClassResourceInterface
{
    /**
     * Retrieve all the translation commits.
     *
     * @ApiDoc(
     *     resource=true,
     *     description="List all translation commits",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the project with given slug does not exist"
     *     },
     *     requirements={
     *         { "name"="source", "dataType"="string", "required"=true, "description"="Source locale" },
     *         { "name"="target", "dataType"="string", "required"=true, "description"="Target locale" },
     *         { "name"="project", "dataType"="string", "required"=true, "description"="Project's slug" }
     *     },
     *     filters={
     *         { "name"="translated", "dataType"="boolean", "required"=false },
     *         { "name"="approved", "dataType"="boolean", "required"=false },
     *         { "name"="text", "dataType"="boolean", "required"=false },
     *         { "name"="page", "dataType"="integer", "required"=false, "default"=1 }
     *     }
     * )
     * @Rest\Get("/translation_commits/{source}/{target}")
     * @Rest\QueryParam(name="project", strict=true, nullable=false)
     * @Rest\View
     */
    public function cgetAction(ParamFetcher $paramFetcher, Request $request, $source, $target)
    {
        $source = Locale::parse($source);
        $target = Locale::parse($target);
        $project = $this->findProjectOr404($paramFetcher->get('project'));

        $specification = new CustomTranslationSpecification($project, $source, $target);

        if ($request->query->has('translated')) {
            $specification->translated = $request->query->get('translated');
        }
        if ($request->query->has('approved')) {
            $specification->approved = $request->query->get('approved');
        }
        if ($request->query->has('text')) {
            $specification->text = $request->query->get('text');
        }

        $pager = $this->get('openl10n.repository.translation')->findSatisfying($specification);
        $pager->setMaxPerPage(2000);

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
     * Retrieve a translation commit.
     *
     * @ApiDoc(
     *     description="Get a translation commit",
     *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404="Returned when the translation with given id does not exist"
     *     },
     *     requirements={
     *         { "name"="source", "dataType"="string", "required"=true, "description"="Source locale" },
     *         { "name"="target", "dataType"="string", "required"=true, "description"="Target locale" },
     *         { "name"="translation", "dataType"="integer", "required"=true, "description"="Translation's id" }
     *     },
     *     output="Openl10n\Bundle\ApiBundle\Facade\TranslationCommit"
     * )
     * @Rest\View
     * @Rest\Get("/translation_commits/{source}/{target}/{translation}")
     */
    public function getAction($source, $target, $translation)
    {
        $translation = $this->findTranslationOr404($translation);

        $source = Locale::parse($source);
        $target = Locale::parse($target);

        return new TranslationCommitFacade($translation, $source, $target);
    }
}
