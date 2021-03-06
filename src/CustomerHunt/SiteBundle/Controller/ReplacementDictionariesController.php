<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\ReplacementDictionaryFormType;
use CustomerHunt\SiteBundle\Form\Type\ReplacementsFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Page;
use CustomerHunt\SystemBundle\Entity\Project;
use CustomerHunt\SystemBundle\Entity\Replacement;
use CustomerHunt\SystemBundle\Entity\ReplacementDictionary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ReplacementDictionariesController extends InitializableController
{
    /**
     * @param Project $project
     * @param Page $page
     * @param ReplacementDictionary $dictionary
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/pages/{page}/replacement-dictionaries/{dictionary}/replacements", name = "site_replacement_dictionaries_replacements",
     *   requirements = {"project": "\d+", "page": "\d+", "dictionary": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id", "project": "project"}})
     * @Config\ParamConverter("dictionary", options = {"mapping": {"dictionary": "id", "page": "page"}})
     */
    public function replacementsAction(Project $project, Page $page, ReplacementDictionary $dictionary)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        if ($dictionary->getReplacements()->count() < 1) $dictionary->getReplacements()->add(new Replacement());

        $form = $this->createForm(new ReplacementsFormType(), $dictionary);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('replacements')->getData() as $replacement) $replacement->setDictionary($dictionary);

            $this->manager->persist($dictionary);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:replacement_dictionaries.html.twig',
                array('notice' => 'replacements_changed', 'caption' => $dictionary->getCaption())
            );
        }

        $this->forms['replacements'] = $form->createView();
        $this->view = array(
            'project' => $project,
            'page' => $page,
            'dictionary' => $dictionary
        );

        return $this->render('CustomerHuntSiteBundle:replacement_dictionaries:replacements.html.twig');
    }

    /**
     * @param Project $project
     * @param Page $page
     * @param ReplacementDictionary $dictionary
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/pages/{page}/replacement-dictionaries/{dictionary}/edit", name = "site_replacement_dictionaries_edit",
     *   requirements = {"project": "\d+", "page": "\d+", "dictionary": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id", "project": "project"}})
     * @Config\ParamConverter("dictionary", options = {"mapping": {"dictionary": "id", "page": "page"}})
     */
    public function editAction(Project $project, Page $page, ReplacementDictionary $dictionary)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new ReplacementDictionaryFormType(), $dictionary);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($dictionary);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:replacement_dictionaries.html.twig',
                array('notice' => 'dictionary_changed', 'caption' => $dictionary->getCaption())
            );

            if ($dictionary->isWithParameter())
                return $this->redirectToRoute('site_replacement_dictionaries_replacements', array(
                    'project' => $project->getId(),
                    'page' => $page->getId(),
                    'dictionary' => $dictionary->getId()
                ));
            else return $this->redirectToRoute('site_pages_page', array(
                'project' => $project->getId(),
                'page' => $page->getId()
            ));
        }

        $this->forms['dictionary'] = $form->createView();
        $this->view = array(
            'project' => $project,
            'page' => $page,
            'dictionary' => $dictionary
        );

        return $this->render('CustomerHuntSiteBundle:replacement_dictionaries:edit.html.twig');
    }

    /**
     * @param Project $project
     * @param Page $page
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/pages/{page}/replacement-dictionaries/add", name = "site_replacement_dictionaries_add", requirements = {"project": "\d+", "page": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id", "project": "project"}})
     */
    public function addAction(Project $project, Page $page)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $dictionary = new ReplacementDictionary();
        $dictionary->setPage($page);
        $form = $this->createForm(new ReplacementDictionaryFormType(), $dictionary);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($dictionary);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:replacement_dictionaries.html.twig',
                array('notice' => 'dictionary_added', 'caption' => $dictionary->getCaption())
            );

            if ($dictionary->isWithParameter())
                return $this->redirectToRoute('site_replacement_dictionaries_replacements', array(
                    'project' => $project->getId(),
                    'page' => $page->getId(),
                    'dictionary' => $dictionary->getId()
                ));
            else return $this->redirectToRoute('site_pages_page', array(
                'project' => $project->getId(),
                'page' => $page->getId()
            ));
        }

        $this->forms['dictionary'] = $form->createView();
        $this->view = array('project' => $project, 'page' => $page);

        return $this->render('CustomerHuntSiteBundle:replacement_dictionaries:add.html.twig');
    }
} 