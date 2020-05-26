<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 04/02/2019
 * Time: 14:23
 */

namespace App\Utils\Files;


use App\Utils\Various\Constant;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;

class PackageUtils
{
    const FILE_VERSION = 1;

    protected $kernel;
    protected $router;

    public function __construct(
        KernelInterface $kernel,
        RouterInterface $router
    )
    {
        $this->kernel = $kernel;
        $this->router = $router;
    }

    public function getUrl($file, $absolute = false)
    {
        // recupere le fichier de versionning
        //        $package = new Package(new EmptyVersionStrategy());
        $package = new Package(
            new JsonManifestVersionStrategy(
                $this->kernel->getProjectDir().'/public/build/manifest.json'
            )
        );

        $url = $package->getUrl($file);
        if (!$absolute) {
            if (substr($url, 0, 1) == '/') {
                $url = substr($url, 1);
            }
        }

        return $url;
    }

    public function getPath($file)
    {
        // recupere le fichier de versionning
        //        $package = new Package(new EmptyVersionStrategy());
        $package = new Package(
            new JsonManifestVersionStrategy(
                $this->kernel->getProjectDir().'/public/build/manifest.json'
            )
        );

        $path = $this->getProjectDir().'/'.Constant::PUBLIC_FOLDER.$package->getUrl($file);

        return $path;
    }

    public function getSharedUrl($file, $version = false)
    {
        if (!$version) {
            $version = self::FILE_VERSION;
        }
//        $package = new UrlPackage(
//            '//'.$this->router->getContext()->getHost().$this->router->getContext()->getBaseUrl(),
//            new StaticVersionStrategy($version)
//        );

        $package = new UrlPackage(
//            '//'.$this->router->getContext()->getHost().':'.$this->router->getContext()->getHttpPort().$this->router->getContext()->getBaseUrl(),
            '//'.$this->router->getContext()->getHost().$this->router->getContext()->getBaseUrl(),
            new StaticVersionStrategy($version)
        );

        return $package->getUrl($file);
    }

    public function getProjectDir()
    {
        return $this->kernel->getProjectDir();
    }

    public function getUploadDir()
    {
        return $this->getProjectDir().'/'.Constant::PUBLIC_FOLDER.'/'.Constant::UPLOAD_FOLDER.'/';
    }

    public function getEnvironment()
    {
        return $this->kernel->getEnvironment();
    }
}
