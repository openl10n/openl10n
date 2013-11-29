<?php

namespace Openl10n\Bundle\UserBundle\Form\Handler;

use HWI\Bundle\OAuthBundle\Form\RegistrationFormHandlerInterface;
use Openl10n\Bundle\UserBundle\Security\User\RegisterUser;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class RegistrationFormHandler implements RegistrationFormHandlerInterface
{
    public function process(Request $request, Form $form, UserResponseInterface $userInformation)
    {
        $action = new RegisterUser();
        $action->username = $userInformation->getNickname();
        $action->email = $userInformation->getEmail();
        $action->displayName = $userInformation->getRealName();

        $form->setData($action);

        if ($request->isMethod('POST')) {
            $form->bind($request);
        }

        return $form->isValid();
    }
}
