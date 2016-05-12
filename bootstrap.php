<?php
declare(strict_types = 1);

use Common\Response;
use DerAlex\Silex\YamlConfigServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;
use MrPrompt\Silex\Cors\Cors as CorsServiceProvider;
use MrPrompt\Silex\Di\Container as DiContainerProvider;
use MrPrompt\Silex\Header\Header as HeaderServiceProvider;
use MrPrompt\Silex\Router\Router as RouterServiceProvider;
use MrPrompt\Silex\Uuid as UuidServiceProvider;
use Palma\Silex\Provider\DoctrineORMServiceProvider;
use Silex\Application as SilexApplication;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * @const string DS
 */
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

/**
 * @const string APPLICATION_ENV
 */
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?: 'production'));

/**
 * Auto loader
 *
 * @var \Composer\Autoload\ClassLoader $loader
 */
$loader = require 'vendor' . DS . 'autoload.php';
$loader->register();

// Fix to read JMS annotations
AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation', __DIR__ . DS . 'vendor' . DS . 'jms' . DS . 'serializer' . DS . 'src'
);

/* @var $configs array */
$configs = [
    'config' . DS . 'global' . DS . 'database.yml',
    'config' . DS . 'global' . DS . 'services.yml',
    'config' . DS . 'global' . DS . 'logger.yml',
];

/**
 * Silex Application
 *
 * @var SilexApplication $app
 */
$app = new SilexApplication();
$app['exception_handler']->disable();

if (APPLICATION_ENV !== 'production') {
    $app['debug']   = true;
    $app['testing'] = true;
}

$configFile = __DIR__ . DS . 'tmp' . DS . 'config.yml';
$strConfig = '';

foreach ($configs as $config) {
    $strConfig .= file_get_contents($config) . PHP_EOL;
}

file_put_contents($configFile, $strConfig);

$app->register(new YamlConfigServiceProvider($configFile));

// Logger Service
$app->register(
    new MonologServiceProvider(),
    [
        'monolog.logfile' => $app['config']['log']['logfile'],
        'monolog.permission' => $app['config']['log']['permission'],
        'monolog.level' => $app['config']['log']['level'],
        'monolog.name' => $app['config']['log']['name'],
    ]
);

// ORM Service
$app->register(
    new DoctrineORMServiceProvider(),
    [
        'doctrine_orm.entities_path' => __DIR__ . DS . 'src',
        'doctrine_orm.proxies_path' => __DIR__ . DS . 'tmp' . DS . 'proxy',
        'doctrine_orm.proxies_namespace' => 'ApplicationPro',
        'doctrine_orm.connection_parameters' => $app['config']['database'][APPLICATION_ENV],
        'doctrine_orm.simple_annotation_reader' => false
    ]
);

// Loading service container
$app->register(new DiContainerProvider($app['config']['services']));

// CORS provider
$app->register(new CorsServiceProvider());

// Token Header Provider
$app->register(new HeaderServiceProvider());

// Uuid Provider
$app->register(new UuidServiceProvider());

// Router Provider
$app->register(new RouterServiceProvider(__DIR__ . DS . 'config' . DS . 'routes' . DS . 'routes.yml'));

$app->before(function (Request $request) use ($app) {
    // Skipping OPTIONS requests
    if ($request->getMethod() === 'OPTIONS') {
        return;
    }

    // If body request is JSON, decode it!
    if (0 === strpos($request->headers->get('Content-Type', 'application/json'), 'application/json')) {
        $data = json_decode($request->getContent(), true);

        $request->request->replace(is_array($data) ? $data : []);
    }
});

$app->after(function (Request $request, Response $response, SilexApplication $app) {
    $app[CorsServiceProvider::HTTP_CORS]($request, $response);
});

$app->error(function (\Exception $e, $code = Response::HTTP_INTERNAL_SERVER_ERROR) {
    if ($e->getCode() !== 0) {
        $code = $e->getCode();
    }

    if ($code > 505 || $code < 100) {
        $code = 500;
    }

    return new Response(["exception" => $e->getMessage(), "status" => "error"], $code);
});

return $app;
