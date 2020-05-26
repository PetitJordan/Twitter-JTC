<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 06/06/2019
 * Time: 12:21
 */

namespace App\Utils\Address;

use Unirest;

class AddressUtils
{
    public function getNormalize($address)
    {
        $headers = array('Accept' => 'application/json');
        $query = array('q' => $address);

        $response = Unirest\Request::get(
            'https://api-adresse.data.gouv.fr/search',
            $headers,
            $query
        );

        // return the result
        $results = $response->body->features;
        $return = array();
        foreach ($results as $result) {
            array_push($return, array(
                'zipcode'      => $result->properties->postcode,
                'address'      => $result->properties->name,
                'city'         => $result->properties->city
            ));
        };

        return $return;
    }
}
