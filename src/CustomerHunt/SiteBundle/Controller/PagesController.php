<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\PageFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Page;
use CustomerHunt\SystemBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends InitializableController
{
    /**
     * @param Project $project
     * @param Page $page
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/pages/{page}/edit", name = "site_pages_edit", requirements = {"project": "\d+", "page": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function editAction(Project $project, Page $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new PageFormType(), $page);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('Page')->createQueryBuilder('p')
                ->select('COUNT(p.id) AS id')
                ->where('p.project = :project')
                ->andWhere('p.caption = :caption')
                ->andWhere('p.id <> :id')
                ->setParameters(array('project' => $project, 'caption' => $page->getCaption(), 'id' => $page->getId()))
                ->getQuery()->getSingleScalarResult();

            $this->manager->persist($page);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:pages.html.twig',
                array('notice' => 'page_changed', 'caption' => $page->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:pages.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $page->getCaption(),
                        'project' => $project->getId(),
                        'page' => $page->getId()
                    )
                );

            return $this-> redirectToRoute('site_pages', array('project' => $project->getId()));
        }

        $this->forms['page'] = $form->createView();
        $this->view = array('project' => $project, 'page' => $page);

        return $this->render('CustomerHuntSiteBundle:pages:edit.html.twig');
    }

    /**
     * @param Project $project
     * @param Page $page
     * @return RedirectResponse
     * @Config\Route("/projects/{project}/pages/{page}/remove", name = "site_pages_remove", requirements = {"project": "\d+", "page": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function removeAction(Project $project, Page $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $caption = $page->getCaption();
        $this->manager->remove($page);
        $this->manager->flush();

        $this->addNotice('success',
            'CustomerHuntSiteBundle:notices:pages.html.twig',
            array('notice' => 'page_removed', 'caption' => $caption)
        );

        return $this->redirectToRoute('site_pages', array('project' => $project->getId()));
    }

    /**
     * @param Project $project
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/pages/add", name = "site_pages_add", requirements = {"project": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function addAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $page = new Page();
        $page->setProject($project);
        $form = $this->createForm(new PageFormType(), $page);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('Page')->createQueryBuilder('p')
                ->select('COUNT(p.id) AS id')
                ->where('p.project = :project')
                ->andWhere('p.caption = :caption')
                ->setParameters(array('project' => $project, 'caption' => $page->getCaption()))
                ->getQuery()->getSingleScalarResult();

            $this->manager->persist($page);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:pages.html.twig',
                array('notice' => 'page_added', 'caption' => $page->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:pages.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $page->getCaption(),
                        'project' => $project->getId(),
                        'page' => $page->getId()
                    )
                );

            return $this-> redirectToRoute('site_pages', array('project' => $project->getId()));
        }

        $this->forms['page'] = $form->createView();
        $this->view['project'] = $project;

        return $this->render('CustomerHuntSiteBundle:pages:add.html.twig');
    }

    /**
     * @param Project $project
     * @param Page $page
     * @return Response
     * @Config\Route("/projects/{project}/pages/{page}", name = "site_pages_page", requirements = {"project": "\d+", "page": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function pageAction(Project $project, Page $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $replacementDictionaries = $this->getRepository('ReplacementDictionary')->createQueryBuilder('d')
            ->where('d.page = :page')
            ->setParameters(array('page' => $page))
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()->getResult();

        $this->view = array(
            'project' => $project,
            'page' => $page,
            'replacementDictionaries' => $replacementDictionaries
        );

        return $this->render('CustomerHuntSiteBundle:pages:page.html.twig');
    }

    /**
     * @param Project $project
     * @return Response
     * @Config\Route("/projects/{project}/pages", name = "site_pages", requirements = {"project": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function indexAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $pages = $this->getRepository('Page')->createQueryBuilder('p')
            ->where('p.project = :project')
            ->setParameters(array('project' => $project))
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()->getResult();

        $this->view = array('project' => $project, 'pages' => $pages);

        return $this->render('CustomerHuntSiteBundle:pages:index.html.twig');
    }
}