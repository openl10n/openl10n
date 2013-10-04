<?php

namespace Openl10n\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('openl10n_project_list'));
    }
}
