<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Domain\Translation\Application\Action\ImportTranslationFileAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImportDomainType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file')
            ->add('domain', 'text')
            ->add('locale', 'openl10n_locale_choice', array(
                'empty_value' => '',
            ))
            ->add('options', 'choice', array(
                'choices' => array(
                    ImportTranslationFileAction::OPTION_REVIEWED => 'Mark translations as reviewed',
                    ImportTranslationFileAction::OPTION_ERASE => 'Ecrase same values',
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
        return 'openl10n_import_domain';
    }
}
