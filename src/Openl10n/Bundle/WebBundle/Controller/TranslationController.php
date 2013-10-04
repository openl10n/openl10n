<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\CoreBundle\Action\SaveTranslationAction;
use Openl10n\Bundle\CoreBundle\Action\SwitchTranslationContextAction;
use Openl10n\Bundle\CoreBundle\Entity\TranslationPhrase as TranslationPhraseEntity;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationPhrase;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\WebBundle\Facade\Model\TranslationFilterBag;
use Openl10n\Bundle\WebBundle\Facade\Specification\TranslationListSpecification;
use Openl10n\Bundle\WebBundle\Facade\Transformer\TranslationCommitTransformer;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TranslationController extends Controller
{
    public function listAction(Request $request, $project, $domain, $target)
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
        $pager->setMaxPerPage(10);

        $action = new SwitchTranslationContextAction($project);
        $action->source = (string) $context->getSource();
        $action->target = (string) $context->getTarget();

        $form = $this->createForm('openl10n_translation_context', $action, array(
            'project' => $project,
        ));

        try {
            $pager->setCurrentPage($request->query->get('page', 1));
        } catch (OutOfRangeCurrentPageException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $transformer = new TranslationCommitTransformer($context);
        $translations = array_map(function($key) use ($transformer) {
            return $transformer->transform($key);
        }, iterator_to_array($pager->getCurrentPageResults()));

        return $this->render('Openl10nWebBundle:Translation:list.html.twig', array(
            'project' => $project,
            'domain' => $domain,
            'context' => $context,
            'pager' => $pager,
            'translations' => $translations,
            'form_context' => $form->createView(),
            'filters' => $filters,
        ));
    }

    public function showAction(Request $request, $project, $domain, $target, $hash)
    {
        $target = new Locale($target);
        $source = $request->query->has('source') ? new Locale($request->query->get('source')) : null;

        $project = $this->findProjectOr404($project);
        $domain = $this->findDomainOr404($project, $domain);
        $language = $this->findLanguageOr404($project, $target);

        $context = $this->get('openl10n.resolver.translation_context')->resolveContext($project, $target, $source);
        $source = $context->getSource();
        $target = $context->getTarget();

        $key = $this->get('openl10n.repository.translation')->findOneByHash($project, $hash);

        if (null === $key) {
            throw $this->createNotFoundException(sprintf('Unable to find translation with hash "%s"', $hash));
        }

        $action = new SwitchTranslationContextAction($project);
        $action->source = (string) $context->getSource();
        $action->target = (string) $context->getTarget();

        $formContext = $this->createForm('openl10n_translation_context', $action, array(
            'project' => $project,
        ));

        $sourcePhrase = $key->getPhrase($source) ?: new TranslationPhrase($key, $source);
        $targetPhrase = $key->getPhrase($target) ?: new TranslationPhraseEntity($key, $target);

        $action = new SaveTranslationAction($key, $target);
        $action->text = $targetPhrase->getText();
        $action->isApproved = $targetPhrase->isApproved();

        $form = $this->createForm('openl10n_translation', $action);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.save_translation')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_translation_list', array(
                'project' => $project->getSlug(),
                'domain' => $domain->getSlug(),
                'target' => $context->getTarget(),
            )));
        }

        return $this->render('Openl10nWebBundle:Translation:show.html.twig', array(
            'project' => $project,
            'domain' => $domain,
            'translation_key' => $key,
            'source_phrase' => $sourcePhrase,
            'context' => $context,
            'hash' => $hash,
            'form' => $form->createView(),
            'form_context' => $formContext->createView(),
        ));
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
}
