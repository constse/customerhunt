<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SystemBundle\Controller\InitializableController;
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
        return $this->forward('CustomerHuntSiteBundle:Projects:index');
    }
}
