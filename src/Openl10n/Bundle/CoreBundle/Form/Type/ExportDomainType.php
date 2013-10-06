<?php

namespace Openl10n\Bundle\CoreBundle\Form\Type;

use Openl10n\Bundle\CoreBundle\Repository\DomainRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Translation\TranslationDumperInterface;
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
    public function __construct(DomainRepositoryInterface $domainRepository, TranslationDumperInterface $translationDumper)
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

                $keys = array_map(function ($domain) { return $domain->getSlug(); }, $domains);
                $values = array_map(function ($domain) { return $domain->getName(); }, $domains);
                $domainList = array_combine($keys, $values);

                $form->add('domain', 'choice', array(
                    'choices' => $domainList,
                ));
            })
            ->add('locale', 'choice', array(
                'choices' => array(
                    'en_GB' => 'English',
                    'fr_FR' => 'French',
                )
            ))
            ->add('format', 'choice', array(
                'choices' => $this->getFormats()
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
