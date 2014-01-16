<?php

namespace Openl10n\Bundle\UserBundle\Controller;

use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Openl10n\Bundle\UserBundle\Action\PasswordUserAction;
use Openl10n\Bundle\UserBundle\Action\DeleteUserAction;
use Openl10n\Bundle\UserBundle\Model\UserInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    public function generalAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $action = new EditUserAction($user);
        $form = $this->createForm('openl10n_user', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.edit_user')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_homepage'));
        }

        return $this->render('Openl10nUserBundle:Settings:general.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function passwordAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $action = new PasswordUserAction($user);
        $form = $this->createForm('openl10n_password_user', $action);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $this->get('openl10n.processor.password_user')->execute($action);

            return $this->redirect($this->generateUrl('openl10n_homepage'));
        }

        return $this->render('Openl10nUserBundle:Settings:password.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    public function leaveAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->get('form.factory')->createBuilder('form')->getForm();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $action = new DeleteUserAction($user);
            $this->get('openl10n.processor.delete_user')->execute($action);

            // Invalidate the user session an token
            $this->get('request')->getSession()->invalidate();
            $this->get('security.context')->setToken(null);

            return $this->redirect($this->generateUrl('openl10n_security_logout'));
        }

        return $this->render('Openl10nUserBundle:Settings:leave.html.twig', array(
            'user' => $user,
            'form'    => $form->createView(),
        ));
    }
}
