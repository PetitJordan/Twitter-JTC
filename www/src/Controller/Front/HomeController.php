<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:43
 */

namespace App\Controller\Front;

use App\Repository\User\UserRepository;

class HomeController extends FrontController
{
    public function home(UserRepository $userRepository)
    {
        // recupere les users
        $users = $userRepository->findAll();

        // rendu template
        return $this->render('front/home/home.html.twig', array(
            'users'         => $users
        ));
    }
}
