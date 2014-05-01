<?php

namespace Openl10n\Bundle\InfraBundle\Form\Transformer;

use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Value\String\Slug;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProjectTransformer implements DataTransformerInterface
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function transform($project)
    {
        if (null === $project) {
            return '';
        }

        return (string) $project->getSlug();
    }

    public function reverseTransform($slug)
    {
        if (!$slug) {
            return null;
        }

        $project = $this->projectRepository->findOneBySlug(new Slug($slug));

        if (null === $project) {
            throw new TransformationFailedException(sprintf(
                'Project "%s" doesn\'t exist',
                $slug
            ));
        }

        return $project;
    }
}
