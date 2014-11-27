<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Repository\LanguageRepository;
use Openl10n\Domain\Resource\Application\Action\ImportTranslationFileAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ImportTranslationFileType extends AbstractType
{
    protected $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                if (null === $data) {
                    return;
                }

                $project = $data->getResource()->getProject();
                $languages = $this->languageRepository->findByProject($project);

                $locales = array_map(function(Language $language) {
                    return (string) $language->getLocale();
                }, $languages);

                $form
                    ->add('locale', 'openl10n_locale_choice', array(
                        'restrict' => $locales,
                    ))
                ;
            })
            ->add('file', 'file')
            ->add('options', 'choice', array(
                'choices' => array(
                    ImportTranslationFileAction::OPTION_REVIEWED => 'Mark translations as reviewed',
                    ImportTranslationFileAction::OPTION_ERASE => 'Erase same values',
                    ImportTranslationFileAction::OPTION_CLEAN => 'Clean unused values',
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
        return 'openl10n_import_translation_file';
    }
}
