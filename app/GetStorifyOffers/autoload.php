<?php
/**
 * Author: Yusuf Shakeel
 * Date: 14-jun-2019 fri
 * Version: 1.0
 *
 * File: autoload.php
 * Description: This file contains autoload.
 */

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new Exception('Required PHP version 5.4 or higher.');
}

spl_autoload_register(function ($class) {

    $namespace = 'GetStorifyOffers\\';

    $baseDir = __DIR__;

    // if class is not using namespace then return
    $len = strlen($namespace);
    if (strncmp($namespace, $class, $len) !== 0) {
        return;
    }

    // get the relative class
    $relativeClass = substr($class, $len);

    // find file
    $file = $baseDir . '/' . str_replace('\\', '/', $relativeClass) . '.php';

    // require the file if exists
    if (file_exists($file)) {
        require $file;
    }

});