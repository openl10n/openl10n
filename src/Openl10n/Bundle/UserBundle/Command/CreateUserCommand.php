<?php

namespace Openl10n\Bundle\UserBundle\Command;

use Openl10n\Domain\User\Application\Action\RegisterUserAction;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('openl10n:user:new')
            ->setDescription('Create a new user')
            ->setDefinition(array(
                new InputOption('username', '', InputOption::VALUE_REQUIRED, 'The user\'s username'),
                new InputOption('display-name', '', InputOption::VALUE_REQUIRED, 'The user\'s name'),
                new InputOption('password', '', InputOption::VALUE_REQUIRED, 'The user\'s password'),
                new InputOption('email', '', InputOption::VALUE_REQUIRED, 'The user\'s email'),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $validator = $this->getContainer()->get('validator');

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
        $username = $dialog->askAndValidate(
            $output,
            'Username: ',
            $validation('username')
        );
        $input->setOption('username', $username);

        // Ask for display name
        $defaultDisplayName = ucfirst($username);
        $input->setOption('username', $dialog->askAndValidate(
            $output,
            'Display name ['.$defaultDisplayName.']: ',
            $validation('displayName'),
            false,
            $defaultDisplayName
        ));

        // Ask for email
        $input->setOption('email', $dialog->askAndValidate(
            $output,
            'Email: ',
            $validation('email')
        ));

        // Ask for password
        $input->setOption('password', $dialog->askHiddenResponseAndValidate(
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
        $errOutput = $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output;

        $action = new RegisterUserAction();
        $action->setUsername($input->getOption('username'));
        $action->setDisplayName($input->getOption('display-name'));
        $action->setEmail($input->getOption('email'));
        $action->setPassword($input->getOption('password'));

        $validator = $this->getContainer()->get('validator');
        $violations = $validator->validate($action);

        if (count($violations) > 0) {
            $errOutput->writeln('<comment>There are some errors:</comment>');
            foreach ($violations as $violation) {
                $errOutput->writeln(sprintf(
                    '  - %s: <error>%s</error>',
                    $violation->getPropertyPath(),
                    $violation->getMessage()
                ));
            }

            return 1;
        }

        $user = $this->getContainer()->get('openl10n.processor.register_user')->execute($action);
        $output->writeln(sprintf('<info>User <comment>%s</comment> created</info>', $user->getUsername()));
    }
}
