<?php

namespace App\Controller\Front;

use App\Repository\Keyword\RequestRepository;

class TrendsController extends FrontController
{
    // Retourne les trends du jour
    public function getTrends(RequestRepository $requestRepository)
    {
        $todayTrends = $requestRepository->findCurrentTrends();

        return $this->render('front/trends/trendings.html.twig', array(
            'trendings' => $todayTrends
        ));
    }

    // Retourne l'évolution du trend sélectionné
    public function visualizeTrend($name, RequestRepository $requestRepository)
    {

        $allEntry = $requestRepository->findEntry($name);

        return $this->render('front/trends/visualizeTrend.html.twig', array(
            'trendName' => $name,
            'allEntry' => $allEntry
        ));
    }
}