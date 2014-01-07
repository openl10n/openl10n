<?php

namespace Openl10n\Bundle\UserBundle\Validator\Constraints;

use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Openl10n\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserValidator extends ConstraintValidator
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

        $value = (string) $value;

        $user = $this->userRepository->findOneByUsername(new Slug($value));
        if (null !== $user) {
            $this->context->addViolation($constraint->message);
        }
    }
}
