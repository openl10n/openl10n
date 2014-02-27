<?php

namespace Openl10n\Bundle\UserBundle\Command;

use Openl10n\Domain\User\Application\Action\RegisterUserAction;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected $action;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('openl10n:user:create')
            ->setDescription('Create a new user')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $validator = $this->getContainer()->get('validator');

        $this->action = new RegisterUserAction();

        // Validation callback: validate a single property of the action.
        $validation = function($property) use ($validator) {
            return function($value) use ($validator, $property) {
                $action = new RegisterUserAction();
                $action->$property = $value;
                $violations = $validator->validateProperty($action, $property);

                if (count($violations) > 0) {
                    throw new \InvalidArgumentException($violations[0]->getMessage());
                }

                return $value;
            };
        };

        // Ask for username
        $this->action->setUsername($dialog->askAndValidate(
            $output,
            'Username: ',
            $validation('username')
        ));

        // Ask for display name
        $defaultDisplayName = ucfirst($this->action->username);
        $this->action->setDisplayName($dialog->askAndValidate(
            $output,
            'Display name ['.$defaultDisplayName.']: ',
            $validation('displayName'),
            false,
            $defaultDisplayName
        ));

        // Ask for email
        $this->action->setEmail($dialog->askAndValidate(
            $output,
            'Email: ',
            $validation('email')
        ));

        // Ask for password
        $this->action->setPassword($dialog->askHiddenResponseAndValidate(
            $output,
            'Password: ',
            $validation('password')
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (null === $this->action) {
            throw new \LogicException('Interaction is required');
        }

        $validator = $this->getContainer()->get('validator');
        $violations = $validator->validate($this->action);

        if (count($violations) > 0) {
            throw new \LogicException('User is not valid');
        }

        $user = $this->getContainer()->get('openl10n.processor.register_user')->execute($this->action);
        $output->writeln(sprintf('<info>User <comment>%s</comment> created</info>', $user->getUsername()));
    }
}
