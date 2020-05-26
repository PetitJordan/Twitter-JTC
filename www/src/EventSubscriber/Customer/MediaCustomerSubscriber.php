<?php

namespace App\EventSubscriber\Customer;


use App\Entity\Customer\CustomerMedia;
use App\Utils\Tools;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;


class MediaCustomerSubscriber
{
    protected $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool|void
     */
    public function onPrePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof CustomerMedia) {
            return;
        }
    }

    public function onPreUpdate(PreUpdateEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();

        if (!$entity instanceof CustomerMedia) {
            return;
        }

        // si on a changé de media, on va essayer de supprimer l'ancienne
        if ($args->hasChangedField('media') && $args->getOldValue('media')) {
            // met l'ancien nom de fichier pour le supprimer
            $entity->setMedia($args->getOldValue('media'));
            $this->tools->fileUtils->deleteMedias($entity);

            // remet le nouveau nom de fichier
            $entity->setMedia($args->getNewValue('media'));
        }
    }

    public function onPostRemove(LifecycleEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();

        $this->tools->fileUtils->deleteMedias($entity);
    }
}
