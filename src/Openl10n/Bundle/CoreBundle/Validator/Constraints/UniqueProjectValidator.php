<?php

namespace Openl10n\Bundle\CoreBundle\Validator\Constraints;

use Openl10n\Bundle\CoreBundle\Action\CreateProjectAction;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Repository\ProjectRepositoryInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueProjectValidator extends ConstraintValidator
{
    /**
     * @var ProjectRepositoryInterface
     */
    private $projectRepository;

    /**
     * @param ProjectRepositoryInterface $projectRepository
     */
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param object     $value
     * @param Constraint $constraint
     *
     * @throws UnexpectedTypeException
     * @throws ConstraintDefinitionException
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        if (empty($value)) {
            return;
        }

        $project = $this->projectRepository->findOneBySlug(new Slug($value));

        if (null !== $project) {
            $this->context->addViolation($constraint->message);
        }
    }
}
