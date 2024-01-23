<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2819cfb8657ac9cf85e8708e4fa0364a
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MyNamespace\\' => 12,
        ),
        'A' => 
        array (
            'AnotherNamespace\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MyNamespace\\' => 
        array (
            0 => __DIR__ . '/../..' . '/int',
        ),
        'AnotherNamespace\\' => 
        array (
            0 => __DIR__ . '/../..' . '/head',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2819cfb8657ac9cf85e8708e4fa0364a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2819cfb8657ac9cf85e8708e4fa0364a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2819cfb8657ac9cf85e8708e4fa0364a::$classMap;

        }, null, ClassLoader::class);
    }
}
