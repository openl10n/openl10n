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
     * @param object     $model
     * @param Constraint $constraint
     *
     * @throws UnexpectedTypeException
     * @throws ConstraintDefinitionException
     */
    public function validate($model, Constraint $constraint)
    {
        if (!$model instanceof CreateProjectAction) {
            throw new UnexpectedTypeException($model, 'Openl10n\Bundle\CoreBundle\Action\CreateProjectAction');
        }

        $slug = $model->slug;

        if (empty($slug)) {
            return true;
        }

        $project = $this->projectRepository->findOneBySlug(new Slug($slug));

        if (null !== $project) {
            $this->context->addViolationAt('slug', $constraint->message);
        }
    }
}
