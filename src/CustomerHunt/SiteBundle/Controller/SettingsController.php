<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\CityFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\City;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends InitializableController
{
    /**
     * @param City $city
     * @return RedirectResponse|Response
     * @Config\Route("/settings/cities/{city}/edit", name = "site_settings_city_edit", requirements = {"city": "\d+"})
     * @config\ParamConverter("city", options = {"mapping": {"city": "id"}})
     */
    public function cityEditAction(City $city)
    {
        $form = $this->createForm(new CityFormType(), $city);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('City')->createQueryBuilder('c')
                ->select('COUNT(c.id) AS id')
                ->where('c.caption = :caption')
                ->andWhere('c.id <> :id')
                ->setParameters(array('caption' => $city->getCaption(), 'id' => $city->getId()))
                ->getQuery()->getSingleScalarResult();

            $this->manager->persist($city);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:settings.html.twig',
                array('notice' => 'city_changed', 'caption' => $city->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:settings.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $city->getCaption(),
                        'city' => $city->getId()
                    )
                );

            return $this->redirectToRoute('site_settings');
        }

        $this->forms['city'] = $form->createView();
        $this->view['city'] = $city;

        return $this->render('CustomerHuntSiteBundle:settings:edit_city.html.twig');
    }

    /**
     * @return RedirectResponse|Response
     * @Config\Route("/settings/cities/add", name = "site_settings_city_add", requirements = {"project": "\d+"})
     */
    public function cityAddAction()
    {
        $city = new City();
        $form = $this->createForm(new CityFormType(), $city);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sames = $this->getRepository('City')->createQueryBuilder('c')
                ->select('COUNT(c.id) AS id')
                ->where('c.caption = :caption')
                ->setParameters(array('caption' => $city->getCaption()))
                ->getQuery()->getSingleScalarResult();

            $this->manager->persist($city);
            $this->manager->flush();

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:settings.html.twig',
                array('notice' => 'city_added', 'caption' => $city->getCaption())
            );

            if ($sames > 0)
                $this->addNotice('warning',
                    'CustomerHuntSiteBundle:notices:settings.html.twig',
                    array(
                        'notice' => 'caption_already_exist',
                        'caption' => $city->getCaption(),
                        'city' => $city->getId()
                    )
                );

            return $this->redirectToRoute('site_settings');
        }

        $this->forms['city'] = $form->createView();

        return $this->render('CustomerHuntSiteBundle:settings:add_city.html.twig');
    }

    /**
     * @return Response
     * @Config\Route("/settings", name = "site_settings")
     */
    public function indexAction()
    {
        $cities = $this->getRepository('City')->createQueryBuilder('c')
            ->orderBy('c.caption', 'ASC')
            ->getQuery()->getResult();

        $this->view['cities'] = $cities;

        return $this->render('CustomerHuntSiteBundle:settings:index.html.twig');
    }
}