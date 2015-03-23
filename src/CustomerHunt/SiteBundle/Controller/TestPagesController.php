<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\TestPageFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Project;
use CustomerHunt\SystemBundle\Entity\TestPage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class TestPagesController extends InitializableController
{
    /**
     * @param Project $project
     * @param TestPage $page
     * @return RedirectResponse|Response
     * @Config\Route("/{project}/test/{page}/edit", name = "site_test_pages_edit", requirements = {"project": "\d+", "page": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function editAction(Project $project, TestPage $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new TestPageFormType(), $page);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('TestPage')->createQueryBuilder('p')
                ->select('COUNT(p.id) AS id')
                ->where('p.project = :project')
                ->andWhere('p.alias = :alias')
                ->andWhere('p.id <> :id')
                ->setParameters(array('project' => $project, 'alias' => $page->getAlias(), 'id' => $page->getId()))
                ->getQuery()->getSingleScalarResult();

            if ($sames < 1) {
                $sames = $this->getRepository('TestPage')->createQueryBuilder('p')
                    ->select('COUNT(p.id) AS id')
                    ->where('p.project = :project')
                    ->andWhere('p.caption = :caption')
                    ->andWhere('p.id <> :id')
                    ->setParameters(array('project' => $project, 'caption' => $page->getCaption(), 'id' => $page->getId()))
                    ->getQuery()->getSingleScalarResult();

                $this->manager->persist($page);
                $this->manager->flush();

                $this->addNotice('success',
                    'CustomerHuntSiteBundle:notices:test_pages.html.twig',
                    array('notice' => 'page_changed', 'caption' => $page->getCaption())
                );

                if ($sames > 0)
                    $this->addNotice('warning',
                        'CustomerHuntSiteBundle:notices:test_pages.html.twig',
                        array(
                            'notice' => 'caption_already_exist',
                            'caption' => $page->getCaption(),
                            'project' => $project->getId(),
                            'page' => $page->getId()
                        )
                    );

                return $this->redirectToRoute('site_test_pages', array('project' => $project->getId()));
            }
            else $form->get('alias')->addError(new FormError('Указанный Вами ЧПУ уже используется. Пожалуйста, укажите другой ЧПУ.'));
        }

        $this->forms['page'] = $form->createView();
        $this->view = array('project' => $project, 'page' => $page);

        return $this->render('CustomerHuntSiteBundle:test_pages:edit.html.twig');
    }

    /**
     * @param Project $project
     * @param TestPage $page
     * @return RedirectResponse
     * @Config\Route("/{project}/test/{page}/remove", name = "site_test_pages_remove", requirements = {"project": "\d+", "page": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function removeAction(Project $project, TestPage $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $caption = $page->getCaption();
        $this->manager->remove($page);
        $this->manager->flush();

        $this->addNotice('success',
            'CustomerHuntSiteBundle:notices:test_pages.html.twig',
            array('notice' => 'page_removed', 'caption' => $caption)
        );

        return $this->redirectToRoute('site_test_pages', array('project' => $project->getId()));
    }

    /**
     * @param Project $project
     * @return RedirectResponse|Response
     * @Config\Route("/{project}/test/add", name = "site_test_pages_add", requirements = {"project": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function addAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $page = new TestPage();
        $page->setProject($project);
        $form = $this->createForm(new TestPageFormType(), $page);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('TestPage')->createQueryBuilder('p')
                ->select('COUNT(p.id) AS id')
                ->where('p.project = :project')
                ->andWhere('p.alias = :alias')
                ->setParameters(array('project' => $project, 'alias' => $page->getAlias()))
                ->getQuery()->getSingleScalarResult();

            if ($sames < 1) {
                $sames = $this->getRepository('TestPage')->createQueryBuilder('p')
                    ->select('COUNT(p.id) AS id')
                    ->where('p.project = :project')
                    ->andWhere('p.caption = :caption')
                    ->setParameters(array('project' => $project, 'caption' => $page->getCaption()))
                    ->getQuery()->getSingleScalarResult();

                $this->manager->persist($page);
                $this->manager->flush();

                $this->addNotice('success',
                    'CustomerHuntSiteBundle:notices:test_pages.html.twig',
                    array('notice' => 'page_added', 'caption' => $page->getCaption())
                );

                if ($sames > 0)
                    $this->addNotice('warning',
                        'CustomerHuntSiteBundle:notices:test_pages.html.twig',
                        array(
                            'notice' => 'caption_already_exist',
                            'caption' => $page->getCaption(),
                            'project' => $project->getId(),
                            'page' => $page->getId()
                        )
                    );

                return $this->redirectToRoute('site_test_pages', array('project' => $project->getId()));
            }
            else $form->get('alias')->addError(new FormError('Указанный Вами ЧПУ уже используется. Пожалуйста, укажите другой ЧПУ.'));
        }

        $this->forms['page'] = $form->createView();
        $this->view['project'] = $project;

        return $this->render('CustomerHuntSiteBundle:test_pages:add.html.twig');
    }

    /**
     * @param Project $project
     * @param TestPage $page
     * @return Response
     * @Config\Route("/{project}/test/{alias}", name = "site_test_pages_page", requirements = {"project": "\d+", "alias": "(\w|-)+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"alias": "alias", "project": "project"}})
     */
    public function testPageAction(Project $project, TestPage $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $this->view['source'] = $page->getSource();

        return $this->render('CustomerHuntSiteBundle:test_pages:page.html.twig');
    }

    /**
     * @param Project $project
     * @return Response
     * @Config\Route("/{project}/test", name = "site_test_pages", requirements = {"project": "\d+"})
     * @Config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function testAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $pages = $this->getRepository('TestPage')->createQueryBuilder('p')
            ->where('p.project = :project')
            ->setParameters(array('project' => $project))
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()->getResult();

        $this->view = array('project' => $project, 'pages' => $pages);

        return $this->render('CustomerHuntSiteBundle:test_pages:index.html.twig');
    }
}