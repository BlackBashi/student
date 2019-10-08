<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd98c61be5496fe493eba5ba61e91c23e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Students\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Students\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd98c61be5496fe493eba5ba61e91c23e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd98c61be5496fe493eba5ba61e91c23e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
