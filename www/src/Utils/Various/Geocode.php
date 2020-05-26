<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 19/03/2019
 * Time: 10:30
 */

namespace App\Utils\Various;


class Geocode
{
    private static $apikey = Constant::GOOGLE_MAPS_KEY_PHP;

    public function geocodeAddress($address)
    {
        //valeurs vide par défaut
        $data = array('address' => '', 'latitude' => null, 'longitude' => null, 'city' => '', 'department' => '', 'region' => '', 'country' => '', 'postal_code' => '');
        //on formate l'adresse
        $address = str_replace(" ", "+", $address);
        try {
            //on fait l'appel à l'API google map pour géocoder cette adresse
            $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=" . self::$apikey . "&address=$address&sensor=false&region=fr");
            $json = json_decode($json);

            // on enregistre les résultats recherchés
            if ($json->status == 'OK' && count($json->results) > 0) {
                $res = $json->results[0];
                //adresse complète et latitude/longitude
                $data['address'] = $res->formatted_address;
                $data['latitude'] = $res->geometry->location->lat;
                $data['longitude'] = $res->geometry->location->lng;
                foreach ($res->address_components as $component) {
                    //ville
                    if ($component->types[0] == 'locality') {
                        $data['city'] = $component->long_name;
                    }
                    //départment
                    if ($component->types[0] == 'administrative_area_level_2') {
                        $data['department'] = $component->long_name;
                    }
                    //région
                    if ($component->types[0] == 'administrative_area_level_1') {
                        $data['region'] = $component->long_name;
                    }
                    //pays
                    if ($component->types[0] == 'country') {
                        $data['country'] = $component->long_name;
                    }
                    //code postal
                    if ($component->types[0] == 'postal_code') {
                        $data['postal_code'] = $component->long_name;
                    }
                }
            }
        } catch (\Exception $exception) {
            return $data;
        }

        return $data;
    }

    public function geocodeAddressByDataGouv($address)
    {
        // Curl INIT
        $ch = curl_init('https://api-adresse.data.gouv.fr/search/?q='.urlencode($address));
        curl_setopt($ch, CURLOPT_TIMEOUT, 45); // timeout de réponse
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //=======================================================================
        // Exécution de la requête                                                          |

        $data = curl_exec($ch);

        //=======================================================================
        // Traitement des erreurs d'execution

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        } else {
            //=======================================================================
            // Traitement du code html retour

            $result = curl_getinfo($ch);

            //=======================================================================
            // Code 200 le corps de la requete contient le  pdf
            // Ecriture dans un fichier temporaire

            if ($result ["http_code"] == "200") {
                curl_close($ch);
                // retour
                $datas = json_decode(trim($data));
                return array(
                    'latitude'          => $datas->features[0]->geometry->coordinates[1] ?? null,
                    'longitude'         => $datas->features[0]->geometry->coordinates[0] ?? null,
                );
            } else {
                //=======================================================================
                // Code <> 200 la requête a échouée
                // Voir liste des code d'erreur
                curl_close($ch);
                return false;
            }
        }
    }

    public function geocodeAddressByDataGouvByFile($pathToFile)
    {
        // Curl INIT
        $ch = curl_init('https://api-adresse.data.gouv.fr/search/csv/');
        curl_setopt($ch, CURLOPT_POST, 1); // méthode POST
        curl_setopt($ch, CURLOPT_TIMEOUT, 45); // timeout de réponse
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'data'          => '@'.realpath($pathToFile)
        ));


        //=======================================================================
        // Exécution de la requête                                                          |

        $data = curl_exec($ch);

        //=======================================================================
        // Traitement des erreurs d'execution

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        } else {
            //=======================================================================
            // Traitement du code html retour

            $result = curl_getinfo($ch);

            //=======================================================================
            // Code 200 le corps de la requete contient le  pdf
            // Ecriture dans un fichier temporaire

            if ($result ["http_code"] == "200") {
                curl_close($ch);
                // retour
                $datas = json_decode(trim($data));
                return array(
                    'latitude'          => $datas->features[0]->geometry->coordinates[1] ?? null,
                    'longitude'         => $datas->features[0]->geometry->coordinates[0] ?? null,
                );
            } else {
                //=======================================================================
                // Code <> 200 la requête a échouée
                // Voir liste des code d'erreur
                curl_close($ch);
                return false;
            }
        }
    }
}
