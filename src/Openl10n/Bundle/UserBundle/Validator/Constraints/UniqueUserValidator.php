<?php

namespace Openl10n\Bundle\UserBundle\Validator\Constraints;

use Openl10n\Domain\User\Repository\UserRepository;
use Openl10n\Domain\User\Value\Username;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserValidator extends ConstraintValidator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
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

        $user = $this->userRepository->findOneByUsername(new Username($value));
        if (null !== $user) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
