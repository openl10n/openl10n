<?php

namespace Openl10n\Bundle\UserBundle\Controller;

use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class RegistrationController extends Controller
{
    public function registrationAction(Request $request, $key)
    {
        $connect = $this->container->getParameter('hwi_oauth.connect');
        if (!$connect) {
            throw $this->createNotFoundHttpException();
        }

        $hasUser = $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if ($hasUser) {
            throw new AccessDeniedException('Cannot connect already registered account.');
        }

        $session = $request->getSession();
        $error = $session->get('_hwi_oauth.registration_error.'.$key);
        //$session->remove('_hwi_oauth.registration_error.'.$key);

        if (!($error instanceof AccountNotLinkedException) || (time() - $key > 300)) {
            throw new \Exception('Cannot register an account.');
        }

        $userInformation = $this
            ->getResourceOwnerByName($error->getResourceOwnerName())
            ->getUserInformation($error->getRawToken())
        ;

        $form = $this->container->get('hwi_oauth.registration.form');

        $formHandler = $this->container->get('hwi_oauth.registration.form.handler');
        if ($formHandler->process($request, $form, $userInformation)) {
            $registerUser = $form->getData();
            $user = new User(new Slug($registerUser->username));
            $user->setEmail(new Email($registerUser->email));
            $user->setDisplayName(new Name($registerUser->displayName));

            $this->container->get('hwi_oauth.account.connector')->connect($user, $userInformation);

            // Authenticate the user
            $this->authenticateUser($request, $user, $error->getResourceOwnerName(), $error->getRawToken());

            return $this->redirect($this->generateUrl('openl10n_homepage'));
        }

        // reset the error in the session
        $key = time();
        $session->set('_hwi_oauth.registration_error.'.$key, $error);

        return $this->render('Openl10nUserBundle:Registration:registration.html.twig', array(
            'key' => $key,
            'form' => $form->createView(),
            'userInformation' => $userInformation,
        ));
    }

    protected function getResourceOwnerByName($name)
    {
        $ownerMap = $this->container->get('hwi_oauth.resource_ownermap.'.$this->container->getParameter('hwi_oauth.firewall_name'));

        if (null === $resourceOwner = $ownerMap->getResourceOwnerByName($name)) {
            throw new \RuntimeException(sprintf("No resource owner with name '%s'.", $name));
        }

        return $resourceOwner;
    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param Request       $request
     * @param UserInterface $user
     * @param string        $resourceOwnerName
     * @param string        $accessToken
     * @param boolean       $fakeLogin
     */
    protected function authenticateUser(Request $request, UserInterface $user, $resourceOwnerName, $accessToken, $fakeLogin = true)
    {
        try {
            $this->container->get('hwi_oauth.user_checker')->checkPostAuth($user);
        } catch (AccountStatusException $e) {
            // Don't authenticate locked, disabled or expired users
            return;
        }

        $token = new OAuthToken($accessToken, $user->getRoles());
        $token->setResourceOwnerName($resourceOwnerName);
        $token->setUser($user);
        $token->setAuthenticated(true);

        $this->container->get('security.context')->setToken($token);

        if ($fakeLogin) {
            // Since we're "faking" normal login, we need to throw our INTERACTIVE_LOGIN event manually
            $this->container->get('event_dispatcher')->dispatch(
                SecurityEvents::INTERACTIVE_LOGIN,
                new InteractiveLoginEvent($request, $token)
            );
        }
    }
}
