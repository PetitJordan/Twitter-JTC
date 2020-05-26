<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 12/11/2018
 * Time: 14:26
 */

namespace App\EventSubscriber;


use App\Entity\Log\UserLog;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSubscriber
{
    protected $entityManager;
    protected $authorizationChecker;

    /**
     * LoginSubscriber constructor.
     * @param EntityManagerInterface $entityManager
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Apres le login
     * @param InteractiveLoginEvent $interactiveLoginEvent
     * @throws \Exception
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $interactiveLoginEvent)
    {
        // recupere user
        $user = $interactiveLoginEvent->getAuthenticationToken()->getUser();
        if ($user && $user instanceof User) {

            $action = UserLog::ACTION_LOGIN;
            if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')
                && !$this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
                $action = UserLog::ACTION_AUTOLOGIN;
            }


            // stats login
            $userLog = new UserLog();
            $userLog->setUser($user);
            $userLog->setAction($action);
            $userLog->setIp(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);
            $userLog->setUserAgent(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null);
            $this->entityManager->persist($userLog);

            // met à jour date dernier login
            $user->setTimeLastLogin(new \DateTime(date('Y-m-d H:i:s')));
            $this->entityManager->persist($user);

            // sauvegarde base
            $this->entityManager->flush();
        }
    }
}
