<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SiteBundle\Form\Type\LoginFormType;
use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\Role;
use CustomerHunt\SystemBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
}
