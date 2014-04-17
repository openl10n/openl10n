<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateResourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file')
            ->add('pathname', 'text')
            ->add('options', 'choice', array(
                'choices' => array(
                    CreateResourceAction::OPTION_REVIEWED => 'Mark translations as reviewed',
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
        return 'openl10n_create_resource';
    }
}
