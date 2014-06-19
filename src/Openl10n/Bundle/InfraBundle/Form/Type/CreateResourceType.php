<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Bundle\InfraBundle\Form\Transformer\ProjectTransformer;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateResourceType extends AbstractType
{
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
            ->add($builder
                ->create('project', 'text')
                ->addModelTransformer(new ProjectTransformer($this->projectRepository))
            )
            ->add('pathname', 'text')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'openl10n_create_resource';
    }

    protected function getProjectChoices()
    {
        $projects = $this->projectRepository->findAll();

        $keys = array_map(function($project) {
            return (string) $project->getSlug();
        }, $projects);

        return array_combine($keys, $keys);
    }
}
