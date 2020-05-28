<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 21/05/2019
 * Time: 15:43
 */

namespace App\Controller\Front;

use App\Service\TwitterService;

/*
 * @param TwitterService $twitterService
 */

class HomeController extends FrontController
{
    public function home(TwitterService $twitterService)
    {
        $pageName = 'home';
        $mesTweets = $twitterService->getTweets();

        // rendu template
        return $this->render('front/home/home.html.twig', array(
            'pageName'  => $pageName,
            'tweets' => $mesTweets
        ));
    }
}
