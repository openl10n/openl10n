<?php

namespace Openl10n\Bundle\UserBundle\Controller;

use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
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
        $error = $this->getErrorForRequest($request);

        if ($error instanceof AccountNotLinkedException) {
            $key = time();
            $session = $request->getSession();
            $session->set('_hwi_oauth.registration_error.'.$key, $error);

            return $this->redirect($this->generateUrl('openl10n_registration', array('key' => $key)));
        }

        if ($error) {
            $message = $error instanceof \Exception ? $error->getMessage() : $error;
            $form->addError(new FormError($message));
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

    protected function getErrorForRequest(Request $request)
    {
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        return $error;
    }
}
