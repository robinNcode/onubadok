<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit9051621d508e0d0db29a07aab79d5db9
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit9051621d508e0d0db29a07aab79d5db9', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit9051621d508e0d0db29a07aab79d5db9', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit9051621d508e0d0db29a07aab79d5db9::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
