<?php

namespace Openl10n\Bundle\CoreBundle\Form\Type;

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
                    'valid'  => 'Mark translations as reviewed',
                    'ecrase' => 'Ecrase same values',
                    'clean'  => 'Clean unused values',
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
