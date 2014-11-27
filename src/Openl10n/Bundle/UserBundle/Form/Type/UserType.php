<?php

namespace Openl10n\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('displayName', 'text', array(
                'label' => 'settings.general.form.name'
            ))
            ->add('preferredLocale', 'openl10n_locale_choice', array(
                'label' => 'settings.general.form.locale'
            ))
            ->add('email', 'email', array(
                'label' => 'settings.general.form.email'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'user',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_user';
    }
}
