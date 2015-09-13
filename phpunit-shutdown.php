<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license proprietary
 * @author Thiago Paes <mrprompt@gmail.com>
 */
$app = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

if ((defined('NO_FIXTURES') || getenv('NO_FIXTURES')) || !file_exists('tmp/phpunit-fixtures.tmp')) {
    $app['logger']->addDebug('No fixtures loaded...');

    return true;
}

$app['logger']->addDebug('Removing temporary databases...');

unlink('tmp/phpunit-fixtures.tmp');
unlink('tmp/phpunit.sqlite');

$app['logger']->addDebug('Terminated...');
