<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\FormHandlerFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\FormField;
use CustomerHunt\SystemBundle\Entity\FormHandler;
use CustomerHunt\SystemBundle\Entity\Page;
use CustomerHunt\SystemBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class FormHandlersController extends InitializableController
{
    /**
     * @param Project $project
     * @param Page $page
     * @param FormHandler $formHandler
     * @return Response
     * @Config\Route("/projects/{project}/pages/{page}/form-handlers/{formHandler}/edit", name = "site_formhandler_form_edit",
     *   requirements = {"project": "\d+", "page": "\d+", "formHandler": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id", "project": "project"}})
     * @Config\ParamConverter("formHandler", options = {"mapping": {"formHandler": "id", "page": "page"}})
     */
    public function editAction(Project $project, Page $page, FormHandler $formHandler)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new FormHandlerFormType(), $formHandler);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('FormHandler')->createQueryBuilder('f')
                ->select('COUNT(f.id) AS id')
                ->where('f.page = :page')
                ->andWhere('f.caption = :caption')
                ->andWhere('f.id <> :id')
                ->setParameters(array(
                    'page' => $page,
                    'caption' => $formHandler->getCaption(),
                    'id' => $formHandler->getId()
                ))->getQuery()->getSingleScalarResult();

            foreach ($formHandler->getFields() as $field) $field->setForm($formHandler);

            $this->manager->persist($formHandler);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:form_handlers.html.twig',
                array('notice' => 'form_changed', 'caption' => $formHandler->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:form_handlers.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $formHandler->getCaption(),
                        'project' => $project->getId(),
                        'page' => $page->getId(),
                        'formHandler' => $formHandler->getId()
                    )
                );

            return $this->redirectToRoute('site_pages_page',
                array('project' => $project->getId(), 'page' => $page->getId())
            );
        }

        $this->forms['form'] = $form->createView();
        $this->view = array(
            'project' => $project,
            'page' => $page,
            'formHandler' => $formHandler
        );

        return $this->render('CustomerHuntSiteBundle:form_handlers:edit.html.twig');
    }

    /**
     * @param Project $project
     * @param Page $page
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/pages/{page}/form-handlers/add", name = "site_formhandler_form_add",
     *   requirements = {"project": "\d+", "page": "\d+", "dictionary": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id", "project": "project"}})
     */
    public function addAction(Project $project, Page $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $formHandler = new FormHandler();
        $formHandler->setPage($page)->getFields()->add(new FormField());
        $form = $this->createForm(new FormHandlerFormType(), $formHandler);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('FormHandler')->createQueryBuilder('f')
                ->select('COUNT(f.id) AS id')
                ->where('f.page = :page')
                ->andWhere('f.caption = :caption')
                ->setParameters(array('page' => $page, 'caption' => $formHandler->getCaption()))
                ->getQuery()->getSingleScalarResult();

            foreach ($formHandler->getFields() as $field) $field->setForm($formHandler);

            $this->manager->persist($formHandler);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:form_handlers.html.twig',
                array('notice' => 'form_added', 'caption' => $formHandler->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:form_handlers.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $formHandler->getCaption(),
                        'project' => $project->getId(),
                        'page' => $page->getId(),
                        'formHandler' => $formHandler->getId()
                    )
                );

            return $this->redirectToRoute('site_pages_page',
                array('project' => $project->getId(), 'page' => $page->getId())
            );
        }

        $this->forms['form'] = $form->createView();
        $this->view = array(
            'project' => $project,
            'page' => $page
        );

        return $this->render('CustomerHuntSiteBundle:form_handlers:add.html.twig');
    }
} 