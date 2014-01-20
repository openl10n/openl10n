<?php

namespace Openl10n\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', 'text', array(
                'label' => 'login.form.username'
            ))
            ->add('_password', 'password', array(
                'label' => 'login.form.password'
            ))
            ->add('_remember_me', 'checkbox', array(
                'label' => 'login.form.remember_me'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_field_name' => '_csrf_token',
            'intention' => 'authenticate',
            'translation_domain' => 'user',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'login';
    }
}
