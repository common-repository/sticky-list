<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f19e828c8240435e93cc63c2ab44ff2
{
    public static $files = array (
        'e2bf578d042d111a8a545e8c6152be54' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'u' => 
        array (
            'ultraDevs\\SL\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ultraDevs\\SL\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f19e828c8240435e93cc63c2ab44ff2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f19e828c8240435e93cc63c2ab44ff2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9f19e828c8240435e93cc63c2ab44ff2::$classMap;

        }, null, ClassLoader::class);
    }
}
