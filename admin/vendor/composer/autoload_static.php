<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitae559297be25d7321a5dfe50d299b439
{
    public static $files = array (
        '6e3fae29631ef280660b3cdad06f25a8' => __DIR__ . '/..' . '/symfony/deprecation-contracts/function.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Dotenv\\' => 25,
            'Safaricom\\Mpesa\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dotenv',
        ),
        'Safaricom\\Mpesa\\' => 
        array (
            0 => __DIR__ . '/..' . '/safaricom/mpesa/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitae559297be25d7321a5dfe50d299b439::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitae559297be25d7321a5dfe50d299b439::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitae559297be25d7321a5dfe50d299b439::$classMap;

        }, null, ClassLoader::class);
    }
}