<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 03/10/2019
 * Time: 16:10
 */

namespace App\EventSubscriber\Customer;

use App\Entity\Customer\TrustedCustomer;
use App\Utils\Tools;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TrustedCustomerLogoSubscriber
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

        if (!$entity instanceof TrustedCustomer) {
            return;
        }
    }

    public function onPreUpdate(PreUpdateEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();

        if (!$entity instanceof TrustedCustomer) {
            return;
        }

        // si on a changé de logo, on va essayer de supprimer l'ancienne
        if ($args->hasChangedField('logo') && $args->getOldValue('logo')) {
            // met l'ancien nom de fichier pour le supprimer
            $entity->setLogo($args->getOldValue('logo'));
            $this->tools->fileUtils->deleteLogos($entity);

            // remet le nouveau nom de fichier
            $entity->setLogo($args->getNewValue('logo'));
        }
    }

    public function onPostRemove(LifecycleEventArgs $args)
    {
        // entite concernee
        $entity = $args->getEntity();

        $this->tools->fileUtils->deleteLogos($entity);
    }
}
