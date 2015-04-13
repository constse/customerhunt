<?php

namespace CustomerHunt\SiteBundle\Controller;

use CustomerHunt\SystemBundle\Controller\InitializableController;
use CustomerHunt\SystemBundle\Entity\FormHandler;
use CustomerHunt\SystemBundle\Entity\Page;
use CustomerHunt\SystemBundle\Entity\Project;
use CustomerHunt\SystemBundle\Entity\ReplacementDictionary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ApiController extends InitializableController
{
    /**
     * @param $code
     * @param Project $project
     * @param Page $page
     * @return JsonResponse|RedirectResponse
     * @Config\Route("/api/form-handler/{code}/{project}/{page}/handle-request", name = "site_api_formhandler_handle",
     *   requirements = {"code": "[0-9a-f]+", "project": "\d+", "page": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function handleFormRequestAction($code, Project $project, Page $page)
    {
        if ($project->getOwner()->getCode() !== $code) throw $this->createNotFoundException();

        if ($this->request->query->get('hunter_form_id')) {
            /** @var FormHandler $handler */
            $handler = $this->getRepository('FormHandler')->createQueryBuilder('f')
                ->leftJoin('f.page', 'p')
                ->where('p = :page')
                ->andWhere('f.id = :id')
                ->setParameters(array('page' => $page, 'id' => $this->request->query->get('hunter_form_id')))
                ->getQuery()->getResult();

            if (is_null($handler)) throw $this->createNotFoundException();

            $body = $handler->getEmailTemplate();

            foreach ($handler->getFields() as $field) {
                $body = preg_replace('/%' . $field->getName() . '%/',
                    $this->request->query->get($field->getName(), 'unknown'),
                    $body
                );
            }

            $body = preg_replace('/%hunter_query%/', $this->request->query->get('hunter_query', 'unknown'), $body);

            $emails = $handler->getEmailRecipients();
            $emails = preg_replace('/(,| |;)+/', ',', $emails);
            $emails = explode(',', $emails);
            /** @var \Swift_Mailer $mailer */
            $mailer = $this->get('mailer');
            $message = $mailer->createMessage()
                ->setSubject('Customer Hunt: ' . $page->getCaption() . ' - обработка формы ' . $handler->getCaption())
                ->setFrom('noreply@navse360.ru')
                ->setTo($emails)
                ->setBody($body, 'text/html');
            $mailer->send($message);

            $callback = $this->request->query->get('callback', 'hunter_formhandler_callback');

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(sprintf('%s(%s);', $callback, json_encode('ok')));

            return $response;
        }

        throw $this->createNotFoundException();
    }

    /**
     * @param $code
     * @param Project $project
     * @param Page $page
     * @return Response
     * @Config\Route("/api/form-handler/{code}/{project}/{page}", name = "site_api_formhandler",
     *   requirements = {"code": "[0-9a-f]+", "project": "\d+", "page": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function formHandlerAction($code, Project $project, Page $page)
    {
        if ($project->getOwner()->getCode() !== $code) throw $this->createNotFoundException();

        $formHandlers = $this->getRepository('FormHandler')->createQueryBuilder('f')
            ->where('f.page = :page')
            ->setParameters(array('page' => $page))
            ->getQuery()->getResult();

        $handlers = array();

        /** @var FormHandler $form */
        foreach ($formHandlers as $form) {
            $handlers[] = array(
                'id' => $form->getId(),
                'selector' => $form->getSelector(),
                'success_redirect' => $form->getSuccessRedirect(),
                'error_redirect' => $form->getErrorRedirect()
            );
        }

        $response = new Response($this->renderView('CustomerHuntSiteBundle:api:form_handler.js.twig', array(
            'action' => $this->generateUrl('site_api_formhandler_handle',
                array('code' => $code, 'project' => $project->getId(), 'page' => $page->getId()),
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
            'handlers' => json_encode($handlers)
        )));
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }

    /**
     * @param string $code
     * @param Project $project
     * @param Page $page
     * @return Response
     * @Config\Route("/api/replacement/{code}/{project}/{page}", name = "site_api_replacement",
     *   requirements = {"code": "[0-9a-f]+", "project": "\d+", "page": "\d+"}
     * )
     * @config\ParamConverter("project", options = {"mapping": {"project": "id"}})
     * @Config\ParamConverter("page", options = {"mapping": {"page": "id"}})
     */
    public function replacementAction($code, Project $project, Page $page)
    {
        if ($project->getOwner()->getCode() !== $code) throw $this->createNotFoundException();

        $parameters = array();
        $replacements = array();

        /** @var ReplacementDictionary $dictionary */
        foreach ($page->getReplacementDictionaries() as $dictionary) {
            $parameter = $dictionary->getParameter();
            $parameters[] = $parameter;
            $selector = array('selector' => $dictionary->getSelector());

            foreach ($dictionary->getReplacements() as $replacement)
                $selector['replacements'][$replacement->getPhrase()] = $replacement->getReplacement();

            $replacements[$parameter][] = $selector;
        }

        $response = new Response($this->renderView('CustomerHuntSiteBundle:api:replacement.js.twig', array(
            'parameters' => json_encode($parameters),
            'replacements' => json_encode($replacements)
        )));
        $response->headers->set('Content-Type', 'text/javascript');

        return $response;
    }
}