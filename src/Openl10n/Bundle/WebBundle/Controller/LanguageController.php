<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Openl10n\Bundle\CoreBundle\Action\CreateLanguageAction;
use Openl10n\Bundle\CoreBundle\Action\DeleteLanguageAction;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LanguageController extends Controller
{
    public function listAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);
        $locales = $this->get('openl10n.repository.language')->findByProject($project);

        // Simple sort by display languages
        usort($locales, function($locale1, $locale2) {
            return strcmp($locale1->getLocale()->getDisplayName(), $locale2->getLocale()->getDisplayName());
        });

        return $this->render('Openl10nWebBundle:Language:list.html.twig', array(
            'project' => $project,
            'locales' => $locales,
        ));
    }

    public function newAction(Request $request, $slug)
    {
        $project = $this->findProjectOr404($slug);

        $action = new CreateLanguageAction($project);
        $form = $this->createForm('openl10n_language', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.create_language')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_language_list', array(
                'slug' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Language:new.html.twig', array(
            'project' => $project,
            'form'    => $form->createView(),
        ));
    }

    public function showAction(Request $request, $slug, $locale)
    {
        $project = $this->findProjectOr404($slug);

        return $this->redirect($this->generateUrl('openl10n_project_show', array(
            'slug' => $project->getSlug()
        )));
    }

    public function deleteAction(Request $request, $slug, $locale)
    {
        $locale = new Locale($locale);

        $project = $this->findProjectOr404($slug);
        $language = $this->findLanguageOr404($project, $locale);

        if ($project->getDefaultLocale()->equals($locale)) {
            return $this->render('Openl10nWebBundle:Language:delete_impossible.html.twig', array(
                'project' => $project,
                'locale' => $language
            ));
        }

        // Create an empty form to only handle the CSRF token
        $form = $this->get('form.factory')->createBuilder('form')->getForm();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $action = new DeleteLanguageAction($language);
            $this->get('openl10n.processor.delete_language')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_language_list', array(
                'slug' => $project->getSlug(),
            )));
        }

        return $this->render('Openl10nWebBundle:Language:delete.html.twig', array(
            'project' => $project,
            'locale' => $language,
            'form' => $form->createView(),
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
