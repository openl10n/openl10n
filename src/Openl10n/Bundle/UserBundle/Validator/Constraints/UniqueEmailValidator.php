<?php

namespace Openl10n\Bundle\UserBundle\Validator\Constraints;

use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\UserBundle\Action\RegisterUserAction;
use Openl10n\Bundle\UserBundle\Entity\UserRepository;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($model, Constraint $constraint)
    {
        //if (!$model instanceof RegisterUserAction) {
        //    throw new UnexpectedTypeException($model, 'Openl10n\Bundle\UserBundle\Action\RegisterUserAction');
        //}

        $email = $model->email;

        if (empty($email)) {
            return true;
        }

        $user = $this->userRepository->findOneByEmail(new Email($email));

        if (null !== $user) {
            $this->context->addViolationAt('email', $constraint->message);
        }
    }
}
