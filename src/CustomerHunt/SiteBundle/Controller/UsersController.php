<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\UserFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends InitializableController
{
    /**
     * @param User $user
     * @Config\Route("/users/{user}/edit", name = "site_users_edit")
     * @Config\ParamConverter("user", options = {"mapping": {"user": "id"}})
     */
    public function editAction(User $user)
    {

    }

    /**
     * @Config\Route("/users/add", name = "site_users_add")
     */
    public function addAction()
    {
        $user = new User();
        $form = $this->createForm(new UserFormType(), $user);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
    }

    /**
     * @return Response
     * @Config\Route("/users", name = "site_users")
     */
    public function indexAction()
    {
        $users = $this->getRepository('User')->createQueryBuilder('u')
            ->leftJoin('u.roles', 'r')
            ->orderBy('u.username', 'ASC')
            ->getQuery()->getResult();

        $this->view['users'] = $users;

        return $this->render('CustomerHuntSiteBundle:users:index.html.twig');
    }
} 