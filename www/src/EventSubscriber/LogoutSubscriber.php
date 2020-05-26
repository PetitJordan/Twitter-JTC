<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 08/01/2019
 * Time: 13:41
 */

namespace App\EventSubscriber;

use App\Entity\Log\UserLog;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutSubscriber implements LogoutHandlerInterface
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param TokenInterface $token
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();

        $userLog = new UserLog();
        $userLog->setAction(UserLog::ACTION_LOGOUT);
        $userLog->setUser($user);
        $userLog->setIp(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null);
        $userLog->setUserAgent(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null);

        $this->manager->persist($userLog);
        $this->manager->flush();
    }
}
