<?php

namespace CustomerHunt\SystemBundle\Controller;

use CustomerHunt\SystemBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

abstract class InitializableController extends Controller
{
    /** @var AuthorizationChecker */
    protected $authChecker;
    /** @var array */
    protected $forms;
    /** @var EntityManager */
    protected $manager;
    /** @var array|EntityRepository[] */
    protected $repositories;
    /** @var Request */
    protected $request;
    /** @var Session */
    protected $session;
    /** @var User */
    protected $user;
    /** @var array */
    protected $view;

    /**
     * @param string $level
     * @param string $view
     * @param array $parameters
     * @return $this
     */
    public function addNotice($level, $view, array $parameters = array())
    {
        $this->addFlash('notices.' . $level, $this->renderView($view, $parameters));

        return $this;
    }

    /**
     * @param $entity
     * @return EntityRepository
     */
    public function getRepository($entity)
    {
        if (!array_key_exists($entity, $this->repositories))
            $this->repositories[$entity] = $this->manager->getRepository('CustomerHuntSystemBundle:' . $entity);

        return $this->repositories[$entity];
    }

    public function initialize(Request $request)
    {
        $this->request = $request;

        $this->authChecker = $this->get('security.authorization_checker');
        $this->forms = array();
        $this->manager = $this->getDoctrine()->getManager();
        $this->repositories = array();
        $this->session = $this->request->getSession();
        $this->user = $this->getUser();
        $this->view = array();
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters = array_merge($parameters, array(
            'forms' => $this->forms,
            'view' => $this->view
        ));

        return parent::render($view, $parameters, $response);
    }
}
