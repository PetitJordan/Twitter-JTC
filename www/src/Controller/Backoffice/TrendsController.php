<?php


namespace App\Controller\Backoffice;


use App\Controller\Front\FrontController;
use App\Entity\Keyword\Request;
use App\Repository\Keyword\RequestRepository;
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
                $this->createTrend($trend->name, $trend->tweet_volume);
            }
        }
        //dump($trendingsWithVolume);die;

        return $this->render('front/trends/trendings.html.twig', array(
        'trendings' => $trendingsWithVolume
    ));
    }

    public function visualizeTrend($name){
        $allEntry = $this->getEntry($name);

        dump($allEntry);
        return $this->render('front/trends/visualizeTrend.html.twig', array(
            'trendName' => $name,
            'allEntry' => $allEntry
        ));
    }

    public function createTrend($trendName, $trendVolume)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $trend = new Request();
        $trend->setName($trendName);
        $trend->setNbTweet($trendVolume);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($trend);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return;
    }

    public function getEntry($trendName){
        $lastEntry = $this->getDoctrine()
            ->getRepository(Request::class)
            ->findEntry($trendName);
        return $lastEntry;
    }
}