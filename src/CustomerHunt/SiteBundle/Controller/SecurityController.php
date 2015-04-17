<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\LoginFormType;
use CustomerHunt\SiteBundle\Form\Type\ProfileFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Role;
use CustomerHunt\SystemBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;

class SecurityController extends InitializableController
{
    /**
     * @return RedirectResponse|Response
     * @Config\Route("/login", name = "site_security_login")
     */
    public function loginAction()
    {
        if ($this->authChecker->isGranted(Role::USER)) return $this->redirectToRoute('site_general_index');

        $error = null;

        if ($this->request->attributes->has(Security::AUTHENTICATION_ERROR))
            $error = $this->request->attributes->get(Security::AUTHENTICATION_ERROR);
        else {
            $error = $this->session->get(Security::AUTHENTICATION_ERROR, null);
            $this->session->remove(Security::AUTHENTICATION_ERROR);
        }

        $form = $this->createForm(new LoginFormType(), new User());

        if (!is_null($error))
            $form->addError(new FormError('Неправильный логин или пароль'));

        $this->forms = array(
            'login' => $form->createView(),
            'last_username' => $this->session->get(Security::LAST_USERNAME, null)
        );

        return $this->render('CustomerHuntSiteBundle:security:login.html.twig');
    }

    /**
     * @throws NotFoundHttpException
     * @Config\Route("/login-check", name = "site_security_login_check")
     */
    public function loginCheckAction()
    {
        throw $this->createNotFoundException();
    }

    /**
     * @throws NotFoundHttpException
     * @Config\Route("/logout", name = "site_security_logout")
     */
    public function logoutAction()
    {
        throw $this->createNotFoundException();
    }

    /**
     * @return RedirectResponse|Response
     * @Config\Route("/profile", name = "site_security_profile")
     */
    public function profileAction()
    {
        $form = $this->createForm(new ProfileFormType(), $this->user);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($form->get('password')->getData())) {
                /** @var UserPasswordEncoder $encoder */
                $encoder = $this->get('security.password_encoder');
                $this->user->setSalt(User::generateSalt())
                    ->setPassword($encoder->encodePassword($this->user, $this->user->getPassword()));
                $this->manager->persist($this->user);
                $this->manager->flush();
            }

            $this->addNotice('success',
                'CustomerHuntSiteBundle:notices:security.html.twig',
                array('notice' => 'user_changed')
            );

            return $this->redirectToRoute('site_general_index');
        }

        $this->forms['profile'] = $form->createView();

        return $this->render('CustomerHuntSiteBundle:security:profile.html.twig');
    }

    /**
     * @param string $target
     * @return RedirectResponse
     * @Config\Route("/refresh-code/{target}", name = "site_security_refresh_code", defaults = {"target": null})
     */
    public function refreshCodeAction($target)
    {
        $this->user->setCode(User::generateCode());
        $this->manager->persist($this->user);
        $this->manager->flush();

        $this->addNotice('success',
            'CustomerHuntSiteBundle:notices:security.html.twig',
            array('notice' => 'code_refreshed')
        );

        if (is_null($target)) return $this->redirectToRoute('site_security_profile');
        else {
            $target = urldecode($target);

            return $this->redirect($target);
        }
    }
}
