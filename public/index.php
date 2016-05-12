<?php
/**
 * Web initializer
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

// Run Forest, run!
$app = require 'bootstrap.php';
$app->run();
