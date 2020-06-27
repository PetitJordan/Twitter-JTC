<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:43
 */

namespace App\Controller\Front;

class HomeController extends FrontController
{
    public function home()
    {
        // rendu template
        return $this->render('front/home/home.html.twig', array(
        ));
    }
}
