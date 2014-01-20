<?php

namespace Openl10n\Bundle\UserBundle\Form\Type;

use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PasswordUserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', 'password', array(
                'label' => 'settings.password.form.old_password'
            ))
            ->add('newPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('required' => true),
                'first_options'  => array('label' => 'settings.password.form.new_password'),
                'second_options' => array('label' => 'settings.password.form.new_password_repeat'),
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
        return 'openl10n_password_user';
    }
}
