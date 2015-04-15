<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\CityFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\City;
use CustomerHunt\SystemBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends InitializableController
{
    /**
     * @param Project $project
     * @param City $city
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/settings/cities/{city}/edit", name = "site_settings_city_edit",
     *   requirements = {"project": "\d+", "city": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @config\ParamConverter("city", options = {"mapping": {"city": "id"}})
     */
    public function cityEditAction(Project $project, City $city)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $form = $this->createForm(new CityFormType(), $city);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($city);
            $this->manager->flush();

            // TODO: notices

            return $this->redirectToRoute('site_settings', array('project' => $project->getId()));
        }

        $this->forms['city'] = $form->createView();
        $this->view = array(
            'project' => $project,
            'city' => $city
        );

        return $this->render('CustomerHuntSiteBundle:settings:edit_city.html.twig');
    }

    /**
     * @param Project $project
     * @return RedirectResponse|Response
     * @Config\Route("/projects/{project}/settings/cities/add", name = "site_settings_city_add", requirements = {"project": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function cityAddAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $city = new City();
        $city->setProject($project);
        $form = $this->createForm(new CityFormType(), $city);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($city);
            $this->manager->flush();

            // TODO: notices

            return $this->redirectToRoute('site_settings', array('project' => $project->getId()));
        }

        $this->forms['city'] = $form->createView();
        $this->view['project'] = $project;

        return $this->render('CustomerHuntSiteBundle:settings:add_city.html.twig');
    }

    /**
     * @param Project $project
     * @return Response
     * @Config\Route("/projects/{project}/settings", name = "site_settings", requirements = {"project": "\d+"})
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     */
    public function indexAction(Project $project)
    {
        if ($project->getOwner() !== $this->user) throw $this->createNotFoundException();

        $cities = $this->getRepository('City')->createQueryBuilder('c')
            ->where('c.project = :project')
            ->setParameters(array('project' => $project))
            ->getQuery()->getResult();

        $this->view = array(
            'project' => $project,
            'cities' => $cities
        );

        return $this->render('CustomerHuntSiteBundle:settings:index.html.twig');
    }
} 