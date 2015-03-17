<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SystemBundle\Controller\InitializableController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;

class GeneralController extends InitializableController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Config\Route("/", name = "site_general_index")
     */
    public function indexAction()
    {
        return $this->render('CustomerHuntSiteBundle:general:index.html.twig');
    }
}
