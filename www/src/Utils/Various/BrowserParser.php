<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 07/06/2019
 * Time: 14:50
 */

namespace App\Utils\Various;

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;

class BrowserParser
{
    /**
     *
     * @param $userAgent
     * @return mixed
     */
    public function getBrowser($userAgent)
    {
        $dd = new DeviceDetector($userAgent);
        $dd->parse();

        return $dd;
    }
}
