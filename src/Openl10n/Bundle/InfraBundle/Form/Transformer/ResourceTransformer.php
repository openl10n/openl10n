<?php

namespace Openl10n\Bundle\InfraBundle\Form\Transformer;

use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ResourceTransformer implements DataTransformerInterface
{
    protected $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function transform($resource)
    {
        if (null === $resource) {
            return '';
        }

        return (string) $resource->getId();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        $resource = $this->resourceRepository->findOneById($value);

        if (null === $resource) {
            throw new TransformationFailedException(sprintf(
                'Resource #%s doesn\'t exist',
                $value
            ));
        }

        return $resource;
    }
}
