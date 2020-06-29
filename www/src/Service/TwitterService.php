<?php

namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService
{
    public function initializeOAuth() {

        $oauth = new TwitterOAuth("jAxFel5JdZl2o0O7p2fxw6zwS", "GoKRO6mVtmn4HAnLW9syEJ5dnmG45gqKZqFGbZUfH4dhWX3YhU");
        $oauth->setTimeouts(15, 20);
        $accessToken = $oauth->oauth2('oauth2/token' , ['grant_type' => 'client_credentials']);

        $twitter = new TwitterOAuth("jAxFel5JdZl2o0O7p2fxw6zwS", "GoKRO6mVtmn4HAnLW9syEJ5dnmG45gqKZqFGbZUfH4dhWX3YhU", null, $accessToken->access_token);
        return $twitter;
    }

    public function getTweets($twittername){

        $twitter = $this->initializeOAuth();
        $tweets = $twitter->get('statuses/user_timeline', ['screen_name' => $twittername, 'exclude_replies' => true]);

        return $tweets;

    }

    // Returns the top 50 trending topics for a specific WOEID
    public function getTrendsPlace(){

        $twitter = $this->initializeOAuth();
        // id 615702 = Paris
        $trendings = $twitter->get('trends/place', ['id' => '615702']);

        return $trendings;

    }
}