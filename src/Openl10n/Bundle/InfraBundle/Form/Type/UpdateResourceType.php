<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Domain\Translation\Application\Action\ImportTranslationFileAction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateResourceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pathname', 'text')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_update_resource';
    }
}
