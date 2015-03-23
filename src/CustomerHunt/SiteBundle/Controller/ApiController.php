<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Page;
use CustomerHunt\SystemBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends InitializableController
{
    /**
     * @param string $code
     * @param Project $project
     * @param Page $page
     * @return Response
     */
    public function replacementAction($code, Project $project, Page $page)
    {
        if ($project->getOwner()->getCode() !== $code) throw $this->createNotFoundException();

        $this->view = array(

        );

        $response = new Response($this->renderView('CustomerHuntSiteBundle:api:replacement.js.twig', array(
            'parameters' => json_encode(array(0)),
            'replacements' => json_encode(array(0))
        )));
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }
}