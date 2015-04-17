<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\UserFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Role;
use CustomerHunt\SystemBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UsersController extends InitializableController
{
    /**
     * @param User $user
     * @return Response
     * @Config\Route("/users/{user}/edit", name = "site_users_edit")
     * @Config\ParamConverter("user", options = {"mapping": {"user": "id"}})
     */
    public function editAction(User $user)
    {
        $form = $this->createForm(new UserFormType(), $user);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $valid = true;
            $sames = $this->getRepository('User')->createQueryBuilder('u')
                ->select('COUNT(u.id) AS id')
                ->where('u.username = :username')
                ->andWhere('u.id <> :id')
                ->setParameters(array('username' => $user->getUsername(), 'id' => $user->getId()))
                ->getQuery()->getSingleScalarResult();

            if ($sames > 0) {
                $form->get('username')->addError(new FormError('Пользователь с таким именем уже существует.'));
                $valid = false;
            }

            if ($valid) {
                if (!is_null($form->get('password')->getData())) {
                    /** @var UserPasswordEncoder $encoder */
                    $encoder = $this->get('security.password_encoder');
                    $user->setSalt(User::generateSalt())
                        ->setPassword($encoder->encodePassword($user, $user->getPassword()));
                }

                $this->manager->persist($user);
                $this->manager->flush();

                $this->addNotice('success',
                    'CustomerHuntSiteBundle:notices:users.html.twig',
                    array('notice' => 'user_changed', 'username' => $user->getUsername())
                );

                return $this->redirectToRoute('site_users');
            }
        }

        $this->forms['user'] = $form->createView();
        $this->view['user'] = $user;

        return $this->render('CustomerHuntSiteBundle:users:edit.html.twig');
    }

    /**
     * @param User $user
     * @Config\Route("/users/{user}/remove", name = "site_users_remove")
     * @Config\ParamConverter("user", options = {"mapping": {"user": "id"}})
     */
    public function removeAction(User $user)
    {

    }

    /**
     * @return RedirectResponse|Response
     * @Config\Route("/users/add", name = "site_users_add")
     */
    public function addAction()
    {
        $user = new User();
        $user->getRolesCollection()->add($this->getRepository('Role')->findOneByRole(Role::USER));
        $form = $this->createForm(new UserFormType(), $user);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $valid = true;
            $sames = $this->getRepository('User')->createQueryBuilder('u')
                ->select('COUNT(u.id) AS id')
                ->where('u.username = :username')
                ->setParameters(array('username' => $user->getUsername()))
                ->getQuery()->getSingleScalarResult();

            if ($sames > 0) {
                $form->get('username')->addError(new FormError('Пользователь с таким именем уже существует.'));
                $valid = false;
            }

            if (is_null($form->get('password')->getData())) {
                $form->get('password')->addError(new FormError('Пожалуйста, укажите пароль пользователя.'));
                $valid = false;
            }

            if ($valid) {
                /** @var UserPasswordEncoder $encoder */
                $encoder = $this->get('security.password_encoder');
                $user->setSalt(User::generateSalt())
                    ->setPassword($encoder->encodePassword($user, $user->getPassword()));
                $this->manager->persist($user);
                $this->manager->flush();

                $this->addNotice('success',
                    'CustomerHuntSiteBundle:notices:users.html.twig',
                    array('notice' => 'user_added', 'username' => $user->getUsername())
                );

                return $this->redirectToRoute('site_users');
            }
        }

        $this->forms['user'] = $form->createView();

        return $this->render('CustomerHuntSiteBundle:users:add.html.twig');
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