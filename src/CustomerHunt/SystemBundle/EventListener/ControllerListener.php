<?php

namespace CustomerHunt\SystemBundle\EventListener;

use CustomerHunt\SystemBundle\Controller\InitializableController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerListener
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) return;

        $controller = $controller[0];

        if ($controller instanceof InitializableController) $controller->initialize($event->getRequest());
    }
}
