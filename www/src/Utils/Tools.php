<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 14/03/2019
 * Time: 15:13
 */
namespace App\Utils;

use App\Utils\Address\AddressUtils;
use App\Utils\Files\FileUtils;
use App\Utils\Files\PackageUtils;
use App\Utils\Mail\Mailer;
use App\Utils\User\UserUtils;
use App\Utils\User\OptinUtils;
use App\Utils\Various\BrowserParser;
use App\Utils\Various\Geocode;
use App\Utils\Various\LocaleUtils;
use App\Utils\Various\ToolString;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class Tools
{
    // Pour avoir accès à la request dans tous les controllers via $this->tools->requestStack->getCurrentRequest()
    public $requestStack;
    // Pour dispatcher les events
    public $eventDispatcher;
    // serializer
    public $serializer;
    // traitement des chaines de caracteres
    public $toolString;
    // utilitaires user
    public $userUtils;
    // utilitaires optins
    public $optinUtils;
    // outil de geocodage
    public $geocode;
    // outil de mail
    public $mailer;
    // Traducteur
    public $translator;
    // Adresses
    public $addressUtils;
    // Browser
    public $browserParser;
    // Packages (& versionning)
    public $packageUtils;
    // Fichiers
    public $fileUtils;
    // locale
	public $localeUtils;

    public function __construct(
        RequestStack $requestStack,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer,
        ToolString $toolString,
        UserUtils $userUtils,
        OptinUtils $optinUtils,
        Geocode $geocode,
        Mailer $mailer,
        TranslatorInterface $translator,
        AddressUtils $addressUtils,
        BrowserParser $browserParser,
        PackageUtils $packageUtils,
        FileUtils $fileUtils,
		LocaleUtils $localeUtils
    ) {
        $this->requestStack = $requestStack;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
        $this->toolString = $toolString;
        $this->userUtils = $userUtils;
        $this->optinUtils = $optinUtils;
        $this->geocode = $geocode;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->addressUtils = $addressUtils;
        $this->browserParser = $browserParser;
        $this->packageUtils = $packageUtils;
        $this->fileUtils = $fileUtils;
        $this->localeUtils = $localeUtils;
    }
}
