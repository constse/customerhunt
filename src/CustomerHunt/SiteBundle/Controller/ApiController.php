<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Page;
use CustomerHunt\SystemBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends InitializableController
{
    /**
     * @param string $code
     * @param Project $project
     * @param Page $page
     * @return Response
     * @Config\Route("/replacement/{code}/{project}/{page}", name = "site_api_replacement", requirements = {"code": "[0-9a-f]+", "project": "\d+", "page": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function replacementAction($code, Project $project, Page $page)
    {
        if ($project->getOwner()->getCode() !== $code) throw $this->createNotFoundException();

        $parameters = array();
        $replacements = array();

        foreach ($page->getReplacementDictionaries() as $dictionary) {
            $parameter = $dictionary->getParameter();
            $parameters[] = $parameter;
            $selector = array('selector' => $dictionary->getSelector());

            foreach ($dictionary->getReplacements() as $replacement)
                $selector['replacements'][$replacement->getPhrase()] = $replacement->getReplacement();

            $replacements[$parameter][] = $selector;
        }

        $response = new Response($this->renderView('CustomerHuntSiteBundle:api:replacement.js.twig', array(
            'parameters' => json_encode($parameters),
            'replacements' => json_encode($replacements)
        )));
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }
}