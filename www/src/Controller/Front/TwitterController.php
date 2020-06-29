<?php

namespace App\Controller\Front;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Repository\User\UserRepository;

class TwitterController extends FrontController
{
    public function showTweets()
    {
        $pageName = 'home';
        $mesTweets = $this->getTweets($this->getUser()->getTwitterName());

        // rendu template
        return $this->render('front/twitter/twitter.html.twig', array(
            'pageName' => $pageName,
            'tweets' => $mesTweets,
        ));
    }

    public function initializeOAuth()
    {
        $oauth = new TwitterOAuth("jAxFel5JdZl2o0O7p2fxw6zwS", "GoKRO6mVtmn4HAnLW9syEJ5dnmG45gqKZqFGbZUfH4dhWX3YhU");
        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);

        $twitter = new TwitterOAuth("jAxFel5JdZl2o0O7p2fxw6zwS", "GoKRO6mVtmn4HAnLW9syEJ5dnmG45gqKZqFGbZUfH4dhWX3YhU", null, $accessToken->access_token);
        return $twitter;
    }

    public function getTweets($twittername)
    {
        $twitter = $this->initializeOAuth();
        $tweets = $twitter->get('statuses/user_timeline', ['screen_name' => $twittername, 'exclude_replies' => true]);

        return $tweets;
    }
}
