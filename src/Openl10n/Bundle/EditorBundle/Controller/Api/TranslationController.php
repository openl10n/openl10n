<?php

namespace Openl10n\Bundle\EditorBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\String\Slug;
use Openl10n\Value\Localization\Locale;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\EditorBundle\Facade\Model\TranslationCommit;
use Openl10n\Bundle\WebBundle\Facade\Model\TranslationFilterBag;
use Openl10n\Bundle\WebBundle\Facade\Specification\TranslationListSpecification;
use Openl10n\Bundle\WebBundle\Facade\Transformer\TranslationCommitTransformer;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Openl10n\Bundle\EditorBundle\Translation\CustomTranslationSpecification;

class TranslationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\View(serializerGroups="list")
     */
    public function cgetAction(Request $request, $project, $target)
    {
        $target = Locale::parse($target);
        $project = $this->findProjectOr404($project);
        $language = $this->findLanguageOr404($project, $target);

        if ($request->query->has('source')) {
            $source = Locale::parse($request->query->get('source'));
        } else {
            $source = $project->getDefaultLocale();
        }

        $specification = new CustomTranslationSpecification($project, $source, $target);

        $pager = $this->get('openl10n.repository.translation')->findSatisfying($specification);
        $pager->setMaxPerPage(1000);

        try {
            $pager->setCurrentPage($request->query->get('page', 1));
        } catch (OutOfRangeCurrentPageException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $translations = array_map(function($key) use ($project, $source, $target) {
            $source = $key->getPhrase($source) ?: new Phrase($key, $source);
            $target = $key->getPhrase($target) ?: new Phrase($key, $target);

            return new TranslationCommit($project, $key->getDomain(), $key, $source, $target);
        }, iterator_to_array($pager->getCurrentPageResults()));

        return array(
            'translations' => $translations,
        );
    }

    /**
     * @Rest\View(serializerGroups="details")
     */
    public function getAction(Request $request, $project, $target, $hash)
    {
        $target = Locale::parse($target);
        $project = $this->findProjectOr404($project);
        $language = $this->findLanguageOr404($project, $target);

        if ($request->query->has('source')) {
            $source = Locale::parse($request->query->get('source'));
        } else {
            $source = $project->getDefaultLocale();
        }

        $key = $this->findTranslationOr404($project, $hash);

        $source = $key->getPhrase($source) ?: new Phrase($key, $source);
        $target = $key->getPhrase($target) ?: new Phrase($key, $target);

        $translation = new TranslationCommit($project, $key->getDomain(), $key, $source, $target);

        return $translation;
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function putAction($project, $target, $hash)
    {
        $target = Locale::parse($target);
        $project = $this->findProjectOr404($project);
        $language = $this->findLanguageOr404($project, $target);

        $key = $this->findTranslationOr404($project, $hash);

        $request = $this->getRequest();
        $translation = $this->get('serializer')->deserialize($request->getContent(), 'Openl10n\Bundle\EditorBundle\Facade\Model\TranslationCommit', 'json');

        if (!$translation->targetPhrase) {
            //throw new \Exception('No phrase to save', 400);
        }

        $action = new EditTranslationPhraseAction($key, $target);
        $action->setText($translation->targetPhrase ?: '');
        $action->setApproved($translation->isApproved);

        $this->get('openl10n.processor.edit_translation')->execute($action);
    }

    protected function findProjectOr404($slug)
    {
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw $this->createNotFoundException(sprintf('Unable to find project with slug "%s"', $slug));
        }

        return $project;
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

    protected function findTranslationOr404(Project $project, $hash)
    {
        $translation = $this->get('openl10n.repository.translation')
            ->findOneByHash($project, $hash)
        ;

        if (null === $translation) {
            throw $this->createNotFoundException(sprintf(
                'Project "%s" has no translation "%s"',
                $project->getSlug(),
                $hash
            ));
        }

        return $translation;
    }
}
