<?php

namespace App\EventSubscriber;

use App\Handler\TranslationHandler;
use App\Handler\UserHandler;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Gedmo\Translatable\Translatable;

/**
 * Class DoctrineEventSubscriber
 * @package App\EventSubscriber
 */
class DoctrineEventSubscriber implements EventSubscriber
{
    /**
     * @var UserHandler
     */
    private $userHandler;

    /**
     * @var TranslationHandler
     */
    private $translationHandler;

    /**
     * DoctrineEventSubscriber constructor.
     * @param UserHandler $userHandler
     * @param TranslationHandler $translationHandler
     */
    public function __construct(UserHandler $userHandler, TranslationHandler $translationHandler)
    {
        $this->userHandler = $userHandler;
        $this->translationHandler = $translationHandler;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->update($args);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->update($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function update(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Translatable) {
            $this->translationHandler->setTranslations($entity, $entity->getTranslations());
        }
    }
}