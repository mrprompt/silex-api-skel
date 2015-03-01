<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel;

use Common\Iterator\Filter\File as FileFilterIterator;
use DerAlex\Silex\YamlConfigServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Dflydev\Silex\Provider\Psr0ResourceLocator\Composer\ComposerResourceLocatorServiceProvider;
use Dflydev\Silex\Provider\Psr0ResourceLocator\Psr0ResourceLocatorServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Silex\Application as SilexApplication;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Skel\View\Json as View;

/**
 * Application Module Bootstrap
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Application extends SilexApplication
{
    /**
     * Construtor
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->before(
            function (Request $request) {
                // Skipping OPTIONS requests
                if ($request->getMethod() === 'OPTIONS') {
                    return;
                }

                // If body request is JSON, decode it!
                if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                    $data = json_decode($request->getContent(), true);
                    $request->request->replace(is_array($data) ? $data : []);
                }
            }
        );

        // Serialize exception messages
        $this->error(
            function (\Exception $e, $code = Response::HTTP_INTERNAL_SERVER_ERROR) {
                if ($e->getCode() !== 0) {
                    $code = $e->getCode();
                }

                if ($code > 505 || $code < 100) {
                    $code = 500;
                }

                return new View($e->getMessage(), $code);
            }
        );
    }

    /**
     * Load config file
     *
     * @param mixed $file
     * @return bool
     */
    public function setConfigFile($file = null)
    {
        if (is_array($file)) {
            foreach ($file as $config) {
                $this->register(new YamlConfigServiceProvider($config));
            }

            return true;
        }

        $this->register(new YamlConfigServiceProvider($file));

        return true;
    }

    /**
     * Load application services
     *
     * @return void
     */
    public function loadServices()
    {
        $this->register(new Psr0ResourceLocatorServiceProvider());

        $this->register(new ComposerResourceLocatorServiceProvider());

        $this->register(
            new MonologServiceProvider(),
            [
                'monolog.logfile' => $this['config']['log']['logfile'],
                'monolog.level'   => $this['config']['log']['level'],
                'monolog.name'    => $this['config']['log']['name']
            ]
        );

        $this->register(
            new DoctrineServiceProvider(),
            [
                "db.options" => $this['config']['database']
            ]
        );

        $this->register(
            new DoctrineOrmServiceProvider(),
            [
                "orm.proxies_dir" => sys_get_temp_dir(),
                'orm.proxies_namespace' => 'SkelDomainEntityProxy',
                'orm.auto_generate_proxies' => true,
                "orm.em.options" => [
                    "mappings" => $this['config']['mappings'],
                    "query_cache" => [
                        "driver" => "array"
                    ],
                    "metadata_cache" => [
                        "driver" => "array"
                    ],
                    "hydratation_cache" => [
                        "driver" => "array"
                    ]
                ]
            ]
        );

        $this->register(
            new SwiftmailerServiceProvider(),
            [
                'swiftmailer.options' => $this['config']['email']['config']
            ]
        );

        $path = __DIR__ . DS . 'Service';
        $extensions = ["php"];

        $recursiveDirectory = new RecursiveDirectoryIterator($path);
        $recursiveIterator = new RecursiveIteratorIterator($recursiveDirectory);
        $filtered = new FileFilterIterator($recursiveIterator, $extensions);

        /* @var $fileInfo \SplFileInfo */
        foreach ($filtered as $fileInfo) {
            $class = __NAMESPACE__ . str_replace(
                [__DIR__, DS],
                ['', '\\'],
                $fileInfo->getPathname()
            );

            $class = str_replace('.php', '', $class);

            $this->register(new $class);
        }
    }

    /**
     * Load controllers
     *
     * @return void
     */
    public function loadControllers()
    {
        $this['routes'] = $this->extend(
            'routes',
            function (RouteCollection $routes, Application $app) {
                $loader = new YamlFileLoader(new FileLocator(__DIR__ . '/../../config'));
                $collection = $loader->load('routes.yml');

                $routes->addCollection($collection);

                return $routes;
            }
        );
    }

    /**
     * Load listeners
     *
     * @return void
     */
    public function loadListeners()
    {
        $path = __DIR__ . DS . 'Event';
        $extensions = ["php"];

        $recursiveDirectory = new RecursiveDirectoryIterator($path);
        $recursiveIterator = new RecursiveIteratorIterator($recursiveDirectory);
        $filtered = new FileFilterIterator($recursiveIterator, $extensions);

        /* @var $fileInfo \SplFileInfo */
        foreach ($filtered as $fileInfo) {
            $class = __NAMESPACE__ . str_replace(
                [__DIR__, DS],
                ['', '\\'],
                $fileInfo->getPathname()
            );

            $class = str_replace('.php', '', $class);

            $this['dispatcher']->addListener($class::NAME, [new $class($this), 'dispatch']);
        }
    }
}
