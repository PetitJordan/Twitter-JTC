<?php

namespace App\Controller\Front;

use App\Service\TwitterService;

class TwitterController extends FrontController
{
    public function showTweets(TwitterService $twitterService)
    {
        $pageName = 'twitter';
        $mesTweets = $twitterService->getTweets($this->getUser()->getTwitterName());

        // rendu template
        return $this->render('front/twitter/twitter.html.twig', array(
            'pageName' => $pageName,
            'tweets' => $mesTweets,
        ));
    }
}
