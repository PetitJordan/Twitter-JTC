<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 16:39
 */

namespace App\Controller\Backoffice;


class DashboardController extends BackofficeController
{
    public function dashboard()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36';
        $browser = $this->tools->browserParser->getBrowser($userAgent);

        // rendu template
        return $this->render('backoffice/dashboard.html.twig', array(

        ));
    }
}
