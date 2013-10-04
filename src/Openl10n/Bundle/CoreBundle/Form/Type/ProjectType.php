<?php

namespace Openl10n\Bundle\CoreBundle\Form\Type;

use Openl10n\Bundle\CoreBundle\Action\CreateProjectAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('defaultLocale', 'openl10n_locale_choice')
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($data instanceof CreateProjectAction) {
                $form->add('slug', 'text');
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_project';
    }
}
