<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 18/06/2018
 * Time: 10:08
 */

namespace App\EventSubscriber\User;

use App\Entity\User\Optin;
use App\Entity\User\User;
use App\Entity\User\UserGroup;
use App\Utils\Mail\Mailer;
use App\Utils\Tools;
use App\Utils\Various\Constant;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class UserSubscriber
{
    protected $tools;
    protected $passwordEncoder;
    protected $entityManager;

    public function __construct(Tools $tools, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->tools = $tools;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function onPreUpdate(PreUpdateEventArgs $args)
    {
        /** @var User $user */
        $user = $args->getEntity();

        if ($args->hasChangedField('email')) {
            $this->tools->optinUtils->checkUserUpdatesEmail($args->getNewValue('email'));
        }
    }

    /**
     * Après update d'un User
     * @param PreUpdateEventArgs $preUpdateEventArgs
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    public function onUpdate(PreUpdateEventArgs $preUpdateEventArgs, LifecycleEventArgs $lifecycleEventArgs)
    {
        // action onUpdate
        $user = $lifecycleEventArgs->getEntity();
    }

    public function onPrePersist(LifecycleEventArgs $args)
    {
        /** @var User $user */
        $user = $args->getObject();

        // Regarde si on a un optin avec le même email
       /* if ($user->getEmail()) {
            $optinCheck = $this->entityManager->getRepository(Optin::class)->findOneBy(
                array(
                    'email'             => $user->getEmail()
                )
            );

            if ($optinCheck) {
                // optin choisi par le user à l'inscription
                $currentActive = $user->getOptin()->getActive();

                // met les infos deja présente en base
                $user->setOptin($optinCheck);
                $user->getOptin()->setActive($currentActive);
                $optinCheck->setUser($user);
                $this->entityManager->persist($optinCheck);
            }
        }*/

        // si pas de status, on met valide par défaut
        if ($user->getIdStatus() === null) {
            $user->setIdStatus(Constant::STATUS_VALIDATE);
        }

        // si pas de role, on met le role user par défaut
        if ((is_array($user->getRoles()) && count($user->getRoles()) == 0) || $user->getRoles() == null) {
            $user->addRole(Constant::ROLE_USER);
        }
    }

    public function onPostPersist(LifecycleEventArgs $args)
    {
        /** @var User $user */
        $user = $args->getObject();



        // Ajoute le group par défaut au user

        // action onPostPersist
       /* $this->tools->mailer->send(
            Mailer::USER_REGISTER,
            $user->getEmail(),
            array(
                'user'      => $user
            )
        );*/
    }
}
