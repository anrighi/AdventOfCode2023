<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf256612f0c131fc1223eca4b3ec2e1e6
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AOC\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AOC\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitf256612f0c131fc1223eca4b3ec2e1e6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf256612f0c131fc1223eca4b3ec2e1e6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf256612f0c131fc1223eca4b3ec2e1e6::$classMap;

        }, null, ClassLoader::class);
    }
}
