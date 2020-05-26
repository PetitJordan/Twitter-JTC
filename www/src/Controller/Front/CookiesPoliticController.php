<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 11/09/2019
 * Time: 14:24
 */

namespace App\Controller\Front;

use App\Controller\Front\FrontController;

class CookiesPoliticController extends FrontController
{
    public function page()
    {
        return $this->render('front/cookies-politic.html.twig', array(

        ));
    }
}