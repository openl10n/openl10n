<?php

namespace Openl10n\Bundle\EditorBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Openl10n\Bundle\CoreBundle\Action\SaveTranslationAction;
use Openl10n\Bundle\CoreBundle\Action\SwitchTranslationContextAction;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationPhrase;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\EditorBundle\Facade\Model\TranslationCommit;
use Openl10n\Bundle\WebBundle\Facade\Model\TranslationFilterBag;
use Openl10n\Bundle\WebBundle\Facade\Specification\TranslationListSpecification;
use Openl10n\Bundle\WebBundle\Facade\Transformer\TranslationCommitTransformer;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class TranslationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\View(serializerGroups="list")
     */
    public function cgetAction(Request $request, $project, $domain, $target)
    {
        $target = new Locale($target);
        $project = $this->findProjectOr404($project);
        $domain = $this->findDomainOr404($project, $domain);
        $language = $this->findLanguageOr404($project, $target);

        $source = $request->query->has('source') ? new Locale($request->query->get('source')) : null;
        $context = $this->get('openl10n.resolver.translation_context')->resolveContext($project, $target, $source);

        $filters = TranslationFilterBag::createFromRequest($request);

        $specification = new TranslationListSpecification($domain, $context, $filters);
        $pager = $this->get('openl10n.repository.translation')->paginateSatisfying($specification);
        $pager->setMaxPerPage(1000);

        try {
            $pager->setCurrentPage($request->query->get('page', 1));
        } catch (OutOfRangeCurrentPageException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $translations = array_map(function($key) use ($project, $domain, $context) {
            $source = $key->getPhrase($context->getSource()) ?: new TranslationPhrase($key, $context->getSource());
            $target = $key->getPhrase($context->getTarget()) ?: new TranslationPhrase($key, $context->getTarget());

            return new TranslationCommit($project, $domain, $key, $source, $target);
        }, iterator_to_array($pager->getCurrentPageResults()));

        return array(
            'translations' => $translations,
        );
    }

    /**
     * @Rest\View(serializerGroups="details")
     */
    public function getAction(Request $request, $project, $domain, $target, $hash)
    {
        $target = new Locale($target);
        $project = $this->findProjectOr404($project);
        $domain = $this->findDomainOr404($project, $domain);
        $language = $this->findLanguageOr404($project, $target);

        $source = $request->query->has('source') ? new Locale($request->query->get('source')) : null;
        $context = $this->get('openl10n.resolver.translation_context')->resolveContext($project, $target, $source);

        $key = $this->findTranslationOr404($project, $hash);

        $source = $key->getPhrase($context->getSource()) ?: new TranslationPhrase($key, $context->getSource());
        $target = $key->getPhrase($context->getTarget()) ?: new TranslationPhrase($key, $context->getTarget());

        $translation = new TranslationCommit($project, $domain, $key, $source, $target);

        return $translation;
    }

    /**
     * @Rest\View(statusCode=204)
     */
    public function putAction($project, $domain, $target, $hash)
    {
        $target = new Locale($target);
        $project = $this->findProjectOr404($project);
        $domain = $this->findDomainOr404($project, $domain);
        $language = $this->findLanguageOr404($project, $target);

        $key = $this->findTranslationOr404($project, $hash);

        $request = $this->getRequest();
        $translation = $this->get('serializer')->deserialize($request->getContent(), 'Openl10n\Bundle\EditorBundle\Facade\Model\TranslationCommit', 'json');

        if (!$translation->targetPhrase) {
            //throw new \Exception('No phrase to save', 400);
        }

        $action = new SaveTranslationAction($key, $target);
        $action->text = $translation->targetPhrase ?: '';
        $action->isApproved = $translation->isApproved;
        $this->get('openl10n.processor.save_translation')->execute($action);
    }

    protected function findProjectOr404($slug)
    {
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw $this->createNotFoundException(sprintf('Unable to find project with slug "%s"', $slug));
        }

        return $project;
    }

    protected function findDomainOr404(ProjectInterface $project, $slug)
    {
        $domain = $this->get('openl10n.repository.domain')->findOneBySlug($project, new Slug($slug));

        if (null === $domain) {
            throw $this->createNotFoundException(sprintf('Unable to find domain with slug "%s"', $slug));
        }

        return $domain;
    }

    protected function findLanguageOr404(ProjectInterface $project, Locale $locale)
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

    protected function findTranslationOr404(ProjectInterface $project, $hash)
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
