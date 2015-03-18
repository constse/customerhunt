<?php

namespace CustomerHunt\SystemBundle\DataFixtures\ORM;

use CustomerHunt\SystemBundle\Entity\Role;
use CustomerHunt\SystemBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class Fixtures implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    protected $container;

    public function load(ObjectManager $manager)
    {
        $roles['user'] = new Role();
        $roles['user']->setRole('ROLE_USER');
        $manager->persist($roles['user']);

        $roles['admin'] = new Role();
        $roles['admin']->setRole('ROLE_ADMIN');
        $manager->persist($roles['admin']);

        $user = new User();
        /** @var UserPasswordEncoder $encoder */
        $encoder = $this->container->get('security.password_encoder');
        $user->setUsername('admin')->setPassword($encoder->encodePassword($user, 'adminpassword'));

        foreach ($roles as $role) $user->getRolesCollection()->add($role);

        $manager->persist($user);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
} 