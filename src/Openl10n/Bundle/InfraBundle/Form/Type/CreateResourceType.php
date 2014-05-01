<?php

namespace Openl10n\Bundle\InfraBundle\Form\Type;

use Openl10n\Bundle\InfraBundle\Form\Transformer\ProjectTransformer;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
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

    protected function getProjectChoices()
    {
        $projects = $this->projectRepository->findAll();

        $keys = array_map(function($project) {
            return (string) $project->getSlug();
        }, $projects);

        return array_combine($keys, $keys);
    }
}
