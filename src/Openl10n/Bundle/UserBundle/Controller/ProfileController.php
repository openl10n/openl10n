<?php

namespace Openl10n\Bundle\UserBundle\Controller;

use Openl10n\Domain\User\Value\Username;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    public function showAction(Request $request, $username)
    {
        $user = $this->findUserOr404($username);

        return $this->render('Openl10nUserBundle:Profile:show.html.twig', array(
            'user' => $user,
        ));
    }

    protected function findUserOr404($username)
    {
        $user = $this->get('openl10n.repository.user')->findOneByUsername(new Username($username));

        if (null === $user) {
            throw $this->createNotFoundException(sprintf('Unable to find user with username "%s"', $username));
        }

        return $user;
    }
}
