<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 07/06/2019
 * Time: 14:54
 */

namespace App\Twig;

use App\Utils\Tools;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    protected $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('os', [$this, 'getOs']),
            new TwigFilter('osVersion', [$this, 'getOsVersion']),
            new TwigFilter('browser', [$this, 'getBrowser']),
            new TwigFilter('version', [$this, 'getVersion']),
            new TwigFilter('slug', [$this, 'getSlug']),
            new TwigFilter('getSmartFileSize', [$this, 'getSmartFileSize'])
        ];
    }

    public function getSmartFileSize($file)
    {
        return $this->tools->fileUtils->getSmartFileSize($file);
    }
    
    public function getOs($userAgent)
    {
        return $this->tools->browserParser->getBrowser($userAgent)->getOs()['name'] ?? null;
    }

    public function getOsVersion($userAgent)
    {
        return $this->tools->browserParser->getBrowser($userAgent)->getOs()['version'] ?? null;
    }

    public function getBrowser($userAgent)
    {
        return $this->tools->browserParser->getBrowser($userAgent)->getClient()['name'] ?? null;
    }

    public function getVersion($userAgent)
    {
        return $this->tools->browserParser->getBrowser($userAgent)->getClient()['version'] ?? null;
    }

    public function getSlug($string)
    {
        return $this->tools->toolString->getSlug($string);
    }
}
