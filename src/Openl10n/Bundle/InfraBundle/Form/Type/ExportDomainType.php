<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Domain\Translation\Service\Dumper\TranslationDumperInterface;
use Openl10n\Domain\Translation\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Translation\Repository\DomainRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ExportDomainType extends AbstractType
{
    protected $domainRepository;
    protected $translationDumper;

    /**
     * @param DomainRepositoryInterface  $domainRepository
     * @param TranslationDumperInterface $translationDumper
     */
    public function __construct(DomainRepository $domainRepository, TranslationDumperInterface $translationDumper)
    {
        $this->domainRepository = $domainRepository;
        $this->translationDumper = $translationDumper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $domainRepository = $this->domainRepository;

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($domainRepository) {
                $form = $event->getForm();
                $data = $event->getData();

                if (null === $data) {
                    return;
                }

                $project = $data->getProject();
                $domains = $domainRepository->findByProject($project);

                $projectLocales = array_map(function($language) {
                    return $language->getLocale()->toString();
                }, $project->getLanguages()->toArray());

                $keys = array_map(function ($domain) { return $domain->getSlug(); }, $domains);
                $values = array_map(function ($domain) { return $domain->getName(); }, $domains);
                $domainList = array_combine($keys, $values);

                $form
                    ->add('domain', 'choice', array(
                        'choices' => $domainList,
                    ))
                    ->add('locale', 'openl10n_locale_choice', array(
                        'restrict' => $projectLocales,
                    ))
                ;
            })
            ->add('format', 'choice', array(
                'choices' => $this->getFormats()
            ))
            ->add('options', 'choice', array(
                'choices' => array(
                    ExportTranslationFileAction::OPTION_REVIEWED => 'Only export reviewed translations',
                    ExportTranslationFileAction::OPTION_FALLBACK_LOCALE => 'Fallback on default locale',
                    ExportTranslationFileAction::OPTION_FALLBACK_KEY => 'Use key as fallback',
                ),
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_export_domain';
    }

    protected function getFormats()
    {
        $formats = $this->translationDumper->getFormats();
        $values = array_map(function($format) {
            return '.'.$format;
        }, $formats);

        return array_combine($formats, $values);
    }
}
