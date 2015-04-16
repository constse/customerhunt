<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\CitiesFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Response;

class ProjectSettingsController extends InitializableController
{
    /**
     * @param Project $project
     * @return Response
     * @Config\Route("/projects/{project}/settings", name = "site_project_settings", requirements = {"project": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function indexAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new CitiesFormType(), $project);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($project);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:projects.html.twig',
                array('notice' => 'project_changed', 'caption' => $project->getCaption())
            );

            $this->redirectToRoute('site_project_settings', array('project' => $project->getId()));
        }

        $this->forms['cities'] = $form->createView();
        $this->view['project'] = $project;

        return $this->render('CustomerHuntSiteBundle:project_settings:index.html.twig');
    }
} 