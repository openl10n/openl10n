<?php

namespace Openl10n\Bundle\UserBundle\Controller;

use Openl10n\Bundle\InfraBundle\Object\Slug;
use Openl10n\Domain\User\Application\Action\DeleteAccountAction;
use Openl10n\Domain\User\Application\Action\ChangePasswordAction;
use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Openl10n\Bundle\UserBundle\Action\DeleteUserAction;
use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Openl10n\Bundle\UserBundle\Action\PasswordUserAction;
use Openl10n\Bundle\UserBundle\Model\UserInterface;
use Openl10n\Domain\User\Application\Action\EditProfileAction;
use Openl10n\Domain\User\Value\Username;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    public function generalAction(Request $request)
    {
        $securityUser = $this->get('security.context')->getToken()->getUser();
        $username = new Username($securityUser->getUsername());

        $user = $this->get('openl10n.repository.user')->findOneByUsername($username);

        $action = new EditProfileAction($user);
        $form = $this->createForm('openl10n_user', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.edit_profile')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_homepage'));
        }

        return $this->render('Openl10nUserBundle:Settings:general.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function passwordAction(Request $request)
    {
        $securityUser = $this->get('security.context')->getToken()->getUser();
        $username = new Username($securityUser->getUsername());

        $user = $this->get('openl10n.repository.user')->findOneByUsername($username);

        $action = new ChangePasswordAction($user);
        $form = $this->createForm('openl10n_password_user', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.change_password')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_homepage'));
        }

        return $this->render('Openl10nUserBundle:Settings:password.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function leaveAction(Request $request)
    {
        $form = $this->get('form.factory')->createBuilder('form')->getForm();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $securityUser = $this->get('security.context')->getToken()->getUser();
            $username = new Username($securityUser->getUsername());
            $user = $this->get('openl10n.repository.user')->findOneByUsername($username);

            $action = new DeleteAccountAction($user);
            $this->get('openl10n.processor.delete_account')->execute($action);

            // Invalidate the user session an token
            $this->get('request')->getSession()->invalidate();
            $this->get('security.context')->setToken(null);

            return $this->redirect($this->generateUrl('openl10n_security_logout'));
        }

        return $this->render('Openl10nUserBundle:Settings:leave.html.twig', array(
            'form'    => $form->createView(),
        ));
    }
}
