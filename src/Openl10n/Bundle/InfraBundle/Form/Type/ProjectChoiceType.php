<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Domain\Project\Repository\ProjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectChoiceType extends AbstractType
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($transformer)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_project_choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }
}
