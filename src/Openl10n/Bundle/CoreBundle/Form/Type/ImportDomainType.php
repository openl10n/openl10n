<?php

namespace Openl10n\Bundle\CoreBundle\Form\Type;

use Openl10n\Bundle\CoreBundle\Action\ImportDomainAction;
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
            ->add('slug', 'text')
            ->add('locale', 'openl10n_locale_choice', array(
                'empty_value' => '',
            ))
            ->add('options', 'choice', array(
                'choices' => array(
                    ImportDomainAction::OPTION_REVIEWED => 'Mark translations as reviewed',
                    ImportDomainAction::OPTION_ERASE => 'Ecrase same values',
                    ImportDomainAction::OPTION_CLEAN => 'Clean unused values',
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
