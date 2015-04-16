<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Role;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Response;

class GeneralController extends InitializableController
{
    /**
     * @return Response
     * @Config\Route("/", name = "site_general_index")
     */
    public function indexAction()
    {
        if (!$this->authChecker->isGranted(Role::ADMIN))
            return $this->redirectToRoute('site_projects');

        return $this->render('CustomerHuntSiteBundle:general:index.html.twig');
    }
}
