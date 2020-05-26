<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 13/09/2019
 * Time: 14:25
 */

namespace App\Controller\Backoffice;

use App\Controller\Backoffice\BackofficeController;
use Symfony\Component\HttpFoundation\JsonResponse;

class GeocodeController extends BackofficeController
{
    public function ajaxGeocodeAddress()
    {
        $address = $this->tools->requestStack->getCurrentRequest()->get('address');
        $geocode = $this->tools->geocode->geocodeAddressByDataGouv($address);
        $error = $geocode ? false : true;

        return new JsonResponse(
            array(
                'error'     => $error,
                'geocode'   => $geocode
            )
        );
    }
}
