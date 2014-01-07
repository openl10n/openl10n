<?php

namespace Openl10n\Bundle\UserBundle\Form\Type;

use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('displayName', 'text')
            ->add('preferedLocale', 'openl10n_locale_choice')
            ->add('email', 'email')
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_user';
    }
}
