<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Bundle\InfraBundle\Form\Transformer\ResourceTransformer;
use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateTranslationKeyType extends AbstractType
{
    protected $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($builder
                ->create('resource', 'text')
                ->addModelTransformer(new ResourceTransformer($this->resourceRepository))
            )
            ->add('identifier', 'text')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_create_translation_key';
    }
}
