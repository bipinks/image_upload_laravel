<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit95e174c2f6a8f715965869646d694e37
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bipinkareparambil\\ImageUploadLaravel\\' => 37,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bipinkareparambil\\ImageUploadLaravel\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit95e174c2f6a8f715965869646d694e37::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit95e174c2f6a8f715965869646d694e37::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit95e174c2f6a8f715965869646d694e37::$classMap;

        }, null, ClassLoader::class);
    }
}
