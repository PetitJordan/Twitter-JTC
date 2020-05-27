<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:43
 */

namespace App\Controller\Front;

use App\Controller\Front\FrontController;
use App\Entity\Contact\Contact;
use App\Form\Front\ContactEditType;
use App\Form\Front\Home\ContactChatType;
use App\Utils\Mail\Mailer;
use App\Utils\Various\ReturnMsgsUtils;

class HomeController extends FrontController
{
    public function home()
    {
        $pageName = 'home';


        // rendu template
        return $this->render('front/home/home.html.twig', array(
            'pageName'  => $pageName,
        ));
    }
}
