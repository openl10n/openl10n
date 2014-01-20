<?php

namespace Openl10n\Bundle\UserBundle\Form\Type;

use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('preferedLocale', 'openl10n_locale_choice', array(
                'label' => 'settings.general.form.locale'
            ))
            ->add('email', 'email', array(
                'label' => 'settings.general.form.email'
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($data instanceof CreateUserAction) {
                $form
                    ->add('username', 'text')
                    ->add('password', 'password');
                ;
            }
        });
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
