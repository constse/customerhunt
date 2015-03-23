<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\ProjectFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectsController extends InitializableController
{
    /**
     * @param Project $project
     * @return RedirectResponse|Response
     * @Config\Route("/{project}/edit", name = "site_projects_edit", requirements = {"project": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function editAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new ProjectFormType(), $project);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('Project')->createQueryBuilder('p')
                ->select('COUNT(p.id) AS id')
                ->where('p.caption = :caption')
                ->andWhere('p.id <> :id')
                ->setParameters(array('caption' => $project->getCaption(), 'id' => $project->getId()))
                ->getQuery()->getSingleScalarResult();

            $this->manager->persist($project);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:projects.html.twig',
                array('notice' => 'project_changed', 'caption' => $project->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:projects.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $project->getCaption(),
                        'project' => $project->getId()
                    )
                );

            return $this->redirectToRoute('site_projects_project', array('project' => $project->getId()));
        }

        $this->forms['project'] = $form->createView();
        $this->view['project'] = $project;

        return $this->render('CustomerHuntSiteBundle:projects:edit.html.twig');
    }

    /**
     * @param Project $project
     * @return RedirectResponse
     * @throws NotFoundHttpException
     * @Config\Route("/{project}/remove", name = "site_projects_remove", requirements = {"project": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function removeAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $caption = $project->getCaption();
        $this->manager->remove($project);
        $this->manager->flush();

        $this->addNotice('success',
            'CustomerHuntSiteBundle:notices:projects.html.twig',
            array('notice' => 'project_removed', 'caption' => $caption)
        );

        return $this->redirectToRoute('site_projects');
    }

    /**
     * @return RedirectResponse|Response
     * @Config\Route("/add", name = "site_projects_add")
     */
    public function addAction()
    {
        $project = new Project();
        $project->setOwner($this->user);
        $form = $this->createForm(new ProjectFormType(), $project);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('Project')->createQueryBuilder('p')
                ->select('COUNT(p.id) AS id')
                ->where('p.caption = :caption')
                ->setParameters(array('caption' => $project->getCaption()))
                ->getQuery()->getSingleScalarResult();

            $this->manager->persist($project);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:projects.html.twig',
                array('notice' => 'project_added', 'caption' => $project->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:projects.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $project->getCaption(),
                        'project' => $project->getId()
                    )
                );

            return $this->redirectToRoute('site_projects');
        }

        $this->forms['project'] = $form->createView();

        return $this->render('CustomerHuntSiteBundle:projects:add.html.twig');
    }


    /**
     * @param Project $project
     * @return Response
     * @Config\Route("/{project}", name = "site_projects_project", requirements = {"project": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function projectAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $this->view['project'] = $project;

        return $this->render('CustomerHuntSiteBundle:projects:project.html.twig');
    }

    /**
     * @return Response
     * @Config\Route("/", name = "site_projects")
     */
    public function indexAction()
    {
        $projects = $this->getRepository('Project')->createQueryBuilder('p')
            ->leftJoin('p.pages', 'pa')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()->getResult();

        $this->view['projects'] = $projects;

        return $this->render('CustomerHuntSiteBundle:projects:index.html.twig');
    }
} 