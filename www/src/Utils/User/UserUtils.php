<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 12/07/2018
 * Time: 10:13
 */

namespace App\Utils\User;


use App\Entity\User;
use App\Entity\UserLog;
use Doctrine\Common\Collections\Criteria;
use Psr\Container\ContainerInterface;

class UserUtils
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return bool|User\User|string
     */
    public function getUserLogged()
    {
        $user = false;
        try {
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                // recupere le user
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
            }
        } catch (\Exception $exception) {
            return false;
        }

        return $user;
    }

    public function isGranted($role)
    {
        if ($this->container->get('security.authorization_checker')->isGranted($role)) {
            return true;
        } else {
            return false;
        }
    }
}
