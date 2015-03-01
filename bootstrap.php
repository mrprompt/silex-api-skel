<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use Skel\Application;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * @const string DS
 */
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

/**
 * @const string APPLICATION_ENV
*/
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/**
 * Auto loader
 *
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require 'vendor' . DS . 'autoload.php';
$loader->register();

// Fix to read JMS annotations
AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation', __DIR__ . '/vendor/jms/serializer/src'
);

/**
 * Silex Application
 *
 * @var \Skel\Application $app
 */
$app = new Application();
$app->setConfigFile([
    'config' . DS . 'config.yml',
    'config' . DS . 'orm.yml',
    'config' . DS . 'global.yml',
]);
$app->loadServices();
$app->loadControllers();
$app->loadListeners();

$app['debug'] = APPLICATION_ENV == 'development' ? true : false;

return $app;
