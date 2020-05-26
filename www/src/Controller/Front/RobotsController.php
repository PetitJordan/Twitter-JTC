<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 20/09/2019
 * Time: 17:22
 */

namespace App\Controller\Front;


use App\Controller\Front\FrontController;

class RobotsController extends FrontController
{
    public function page()
    {
        // ----------------------------------------------------------------------
        // Rendu template
        return $this->render('robots.html.twig', array(

        ));
    }
}
