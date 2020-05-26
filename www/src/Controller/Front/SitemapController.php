<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 20/09/2019
 * Time: 16:47
 */

namespace App\Controller\Front;


use App\Controller\Front\FrontController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends FrontController
{
    public function sitemap()
    {
        /* fréquences possible :
         * always
         * hourly
         * daily
         * weekly
         * monthly
         * yearly
         * never
         */
        // priority : 0.2 / 0.5 / 0.8 / 1

        $urls = array();

        // ----------------------------------------------------------------------
        // Accueil
        array_push($urls, array(
            'loc'           => $this->generateUrl('index', array(), UrlGeneratorInterface::ABSOLUTE_URL),
            'changefreq'    => 'monthly',
            'priority'      => 1
        ));

        // ----------------------------------------------------------------------
        // Rendu template
        return $this->render('sitemap.html.twig', array(
            'urls'          => $urls
        ));
    }
}
