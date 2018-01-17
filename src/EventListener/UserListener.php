<?php

namespace App\EventListener;

use App\Entity\User;
use App\Handler\UserHandler;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;

/**
 * Class UserListener
 * @package App\Doctrine
 */
class UserListener
{
    /**
     * @var UserHandler
     */
    private $userHandler;

    /**
     * UserListener constructor.
     * @param UserHandler $userHandler
     */
    public function __construct(UserHandler $userHandler)
    {
        $this->userHandler = $userHandler;
    }

    /**
     * @param User $user
     * @param LifecycleEventArgs $args
     */
    public function prePersist(User $user, LifecycleEventArgs $args)
    {
        $this->userHandler->hashPassword($user);
    }

    /**
     * @param User $user
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(User $user, PreUpdateEventArgs $args)
    {
        $this->userHandler->hashPassword($user);
    }
}
