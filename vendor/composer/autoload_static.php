<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita5bfa0c3499a45ba7503086c8b4d0c77
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Snilius\\Twig\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Snilius\\Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/snilius/twig-sort-by-field/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita5bfa0c3499a45ba7503086c8b4d0c77::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita5bfa0c3499a45ba7503086c8b4d0c77::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
