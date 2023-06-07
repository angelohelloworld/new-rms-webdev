<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaec6af291b359e44dbef426c8c619bc1
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaec6af291b359e44dbef426c8c619bc1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaec6af291b359e44dbef426c8c619bc1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaec6af291b359e44dbef426c8c619bc1::$classMap;

        }, null, ClassLoader::class);
    }
}