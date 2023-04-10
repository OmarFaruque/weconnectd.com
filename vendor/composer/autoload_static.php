<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab65542c247795d83d0f464fc8422528
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MatthiasMullie\\PathConverter\\' => 29,
            'MatthiasMullie\\Minify\\' => 22,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MatthiasMullie\\PathConverter\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/path-converter/src',
        ),
        'MatthiasMullie\\Minify\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/minify/src',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab65542c247795d83d0f464fc8422528::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab65542c247795d83d0f464fc8422528::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitab65542c247795d83d0f464fc8422528::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitab65542c247795d83d0f464fc8422528::$classMap;

        }, null, ClassLoader::class);
    }
}