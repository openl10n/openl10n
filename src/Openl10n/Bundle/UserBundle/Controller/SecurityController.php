<?php

namespace Openl10n\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        // Redirect authenticated user to homepage
        if (null !== $this->getUser()) {
            return $this->redirect($this->generateUrl('openl10n_homepage'));
        }

        // Create login form
        $form = $this->get('form.factory')->createNamed('', 'login');

        if ($error = $this->getErrorMessage()) {
            $form->addError(new FormError($error));
        }

        return $this->render('Openl10nUserBundle:Security:login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    protected function getErrorMessage()
    {
        $request = $this->getRequest();
        $attrs = $request->attributes;
        $session = $request->getSession();

        if ($attrs->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $attrs->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        return $error instanceof \Exception ? $error->getMessage() : $error;
    }
}
