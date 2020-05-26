<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 17/06/2019
 * Time: 09:59
 */

namespace App\EventSubscriber\User;


use App\Entity\User\Optin;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class OptinSubscriber
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return bool|void
     */
    public function onPrePersist(LifecycleEventArgs $args)
    {
        /** @var Optin $user */
        $optin = $args->getObject();

        if (!$optin instanceof Optin) {
            return;
        }

        // si pas de active, on met 1 par défaut
        if ($optin->getActive() === null) {
            $optin->setActive(1);
        }

        // Si l'email corresponds à un utilisateur
        if ($optin->getEmail()) {
            $userCheck = $this->entityManager->getRepository(User::class)->findOneBy(
                array(
                    'email'         => $optin->getEmail()
                )
            );

            if ($userCheck) {
                if ($userCheck->getOptin()) {
                    $this->entityManager->detach($optin);
                    return false;
                }
                $optin->setUser($userCheck);
            }
        } else { // si user et pas d'email
            if ($optin->getUser()) {
                $optin->setEmail($optin->getUser()->getEmail());
            }
        }

    }
}
