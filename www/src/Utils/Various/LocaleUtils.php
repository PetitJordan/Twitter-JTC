<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 07/10/2019
 * Time: 09:16
 */

namespace App\Utils\Various;


use Symfony\Component\HttpFoundation\RequestStack;

class LocaleUtils
{
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getLocale()
    {
        return $this->requestStack->getCurrentRequest()->getLocale();
    }

    public function getDefaultLocale()
    {
        return $this->requestStack->getCurrentRequest()->getDefaultLocale();
    }
}
