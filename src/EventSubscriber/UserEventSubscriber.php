<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Exception\UserExistsException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class UserEventSubscriber
 * @package App\EventSubscriber
 */
final class UserEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var RegistryInterface
     */
    private $doctrine;

    /**
     * UserEventSubscriber constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['checkUser', EventPriorities::PRE_WRITE],
        ];
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     * @throws UserExistsException
     */
    public function checkUser(GetResponseForControllerResultEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) {
            return;
        }

        $repository = $this->doctrine->getManager()->getRepository('App:User');
        $userExists = $repository->loadUserByUsername($user->getEmail(), $user->getUsername());
        if($userExists) {
            throw new UserExistsException('User exist.');
        }
    }
}