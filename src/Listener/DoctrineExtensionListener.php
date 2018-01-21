<?php

namespace App\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Class DoctrineExtensionListener
 * @package App\Listener
 */
class DoctrineExtensionListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function onLateKernelRequest(GetResponseEvent $event)
    {
        $translatable = $this->container->get('gedmo.listener.translatable');
        $translatable->setTranslatableLocale($event->getRequest()->getLocale());
    }

    /**
     * @inheritdoc
     */
    public function onConsoleCommand()
    {
        $this->container->get('gedmo.listener.translatable')
            ->setTranslatableLocale($this->container->get('translator')->getLocale());
    }

    /**
     * @inheritdoc
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
//        $tokenStorage = $this->container->get('security.token_storage')->getToken();
//        $authorizationChecker = $this->container->get('security.authorization_checker');
//        if (null !== $tokenStorage && $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//            $loggable = $this->container->get('gedmo.listener.loggable');
//            $loggable->setUsername($tokenStorage->getUser());
//            $blameable = $this->container->get('gedmo.listener.blameable');
//            $blameable->setUserValue($tokenStorage->getUser());
//        }
    }
}