<?php


namespace App\Controller\Backoffice;


use App\Controller\Front\FrontController;
use App\Service\TwitterService;

class TrendsController extends FrontController
{
    public function getTrends(TwitterService $twitterService)
    {
        $trendings = $twitterService->getTrendsPlace();
        $trendingsWithVolume = array();
        foreach ($trendings['0']->trends as $trend){
            if (isset($trend->tweet_volume)){
                $trendingsWithVolume[$trend->name] = $trend->tweet_volume;
            }
        }
        //dump($trendingsWithVolume);die;

        return $this->render('front/trends/trendings.html.twig', array(
        'trendings' => $trendingsWithVolume
    ));
    }
}