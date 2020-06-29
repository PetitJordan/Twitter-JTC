<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 12/10/2018
 * Time: 10:20
 */

namespace App\EventSubscriber;

use App\Entity\Customer\CustomerMedia;
use App\Entity\Customer\TrustedCustomer;

use App\Entity\User\Optin;
use App\Entity\User\User;
use App\EventSubscriber\Customer\MediaCustomerSubscriber;
use App\EventSubscriber\Customer\TrustedCustomerLogoSubscriber;
use App\EventSubscriber\User\OptinSubscriber;
use App\EventSubscriber\User\UserSubscriber;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class EventsSubscriber implements EventSubscriber
{
    protected $userSubscriber;




    public function __construct(
        UserSubscriber $userSubscriber

    ) {
        $this->userSubscriber = $userSubscriber;
    }

    /** @var PreUpdateEventArgs $preUpdateEventArgs */
    private $preUpdateEventArgs;

    public function getSubscribedEvents()
    {
        return array(
            'preUpdate',
            'prePersist',
            'postPersist',
            'postUpdate',
            'postRemove',
        );
    }

    /**
     * Event preUpdate, se déclance AVANT UPDATE
     * Utile pour regarder les modifications apportées
     * Toutes les données sont stockées dans la variables $preUpdateEventArgs pour pouvoir être utilisées dans le postUpdate
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->preUpdateEventArgs = $args;

        // entite concernee
        $entity = $args->getEntity();

        // Si User
        if ($entity instanceof User) {
            $this->userSubscriber->onPreUpdate($this->preUpdateEventArgs);
        }

    }

    /**
     * Event postRemove, se déclenche APRES REMOVE
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();
    }

    /**
     * Event postUpdate, se déclenche APRES UPDATE
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args) {
        // entite concernee
        $entity = $args->getEntity();

        // Si User
        if ($entity instanceof User) {
            $this->userSubscriber->onUpdate($this->preUpdateEventArgs, $args);
        }
    }

    /**
     * Event prePersist, se déclenche AVANT INSERT
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();

        // Si User
        if ($entity instanceof User) {
            $this->userSubscriber->onPrePersist($args);
        }
    }

    /**
     * Event postPersist, se déclenche APRES INSERT
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();

        // Si User
        if ($entity instanceof User) {
            $this->userSubscriber->onPostPersist($args);
            return;
        }

    }
}
