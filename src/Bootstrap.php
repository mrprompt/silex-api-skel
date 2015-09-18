<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel;

use Skel\Response as View;
use DerAlex\Silex\YamlConfigServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Dflydev\Silex\Provider\Psr0ResourceLocator\Psr0ResourceLocatorServiceProvider;
use MrPrompt\Silex\Di\Container as DiContainerProvider;
use MrPrompt\Silex\Cors\Cors as CorsServiceProvider;
use MrPrompt\Silex\Hmac\Hmac as HmacServiceProvider;
use Silex\Application as SilexApplication;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Loader\YamlFileLoader as RoutingFileLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Translation\Loader\YamlFileLoader as TranslationFileLoader;

/**
 * Application Module Bootstrap
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Romeu Mattos <romeu.smattos@gmail.com>
 */
class Bootstrap extends SilexApplication
{
    /**
     * Constructor
     *
     * @param array $values
     * @param array $configs
     * @param string $route
     */
    public function __construct(array $values = [], array $configs = [], $route = null)
    {
        parent::__construct($values);

        $this['debug'] = false;

        $this['exception_handler']->disable();

        $this->config($configs);

        $this->services();

        $this->translations();

        $this->listeners();

        $this->providers();

        $this->controllers($route);

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

                // setting translator
                try {
                    $this['translator']->setLocale(strtolower($request->headers->get('Accept-Language')));
                } catch (\InvalidArgumentException $ex) {
                    // do noting
                }

                // Dispatch property before event
                $this['dispatcher']->dispatch($request->attributes->get('_route') . '.before');
            }
        );

        $this->after(
            function (Request $request, Response $response, Bootstrap $app) {
                $app[CorsServiceProvider::HTTP_CORS]($request, $response);

                $this['dispatcher']->dispatch($request->attributes->get('_route') . '.after');
            }
        );

        $this->finish(
            function (Request $request, Response $response) {
                $this['dispatcher']->dispatch($request->attributes->get('_route') . '.finish');
            }
        );

        $this->error(
            function (\Exception $e, $code = Response::HTTP_INTERNAL_SERVER_ERROR) {
                if ($e->getCode() !== 0) {
                    $code = $e->getCode();
                }

                if ($code > 505 || $code < 100) {
                    $code = 500;
                }

                return new View(["exception" => $e->getMessage(), "status" => "error"], $code);
            }
        );
    }

    /**
     * Load controllers
     *
     * @param $routeFile
     * @internal param string $routesPath
     */
    private function controllers($routeFile)
    {
        $this['routes'] = $this->extend(
            'routes',
            function (RouteCollection $routes) use ($routeFile) {
                $routesPath = dirname($routeFile);
                $loader     = new RoutingFileLoader(new FileLocator($routesPath));
                $collection = $loader->load(basename($routeFile));

                $routes->addCollection($collection);

                return $routes;
            }
        );
    }

    /**
     * Load configurations files
     *
     * @param array $file
     * @return bool
     */
    private function config(array $file = [])
    {
        foreach ($file as $config) {
            $this->register(new YamlConfigServiceProvider($config));
        }

        return true;
    }

    /**
     * Load application services
     *
     * @return void
     */
    private function services()
    {
        // Resource locator service
        $this->register(new Psr0ResourceLocatorServiceProvider());

        // Logger Service
        $this->register(
            new MonologServiceProvider(),
            [
                'monolog.logfile'   => $this['config']['log']['logfile'],
                'monolog.permission'=> $this['config']['log']['permission'],
                'monolog.level'     => $this['config']['log']['level'],
                'monolog.name'      => $this['config']['log']['name'],
            ]
        );

        // DBAL Service
        $this->register(
            new DoctrineServiceProvider(),
            [
                "db.options" => $this['config']['database'][APPLICATION_ENV]
            ]
        );

        // ORM Service
        $this->register(
            new DoctrineOrmServiceProvider(),
            [
                "orm.proxies_dir"           => 'tmp/proxy/',
                'orm.proxies_namespace'     => 'Proxy',
                'orm.auto_generate_proxies' => APPLICATION_ENV !== 'production' ? true : false,
                "orm.em.options"            => [
                    "mappings"          => $this['config']['mappings'],
                    "query_cache"       => [ "driver" => "array" ],
                    "metadata_cache"    => [ "driver" => "array" ],
                    "hydratation_cache" => [ "driver" => "array" ]
                ]
            ]
        );

        // Register translator service
        $this->register(
            new TranslationServiceProvider(),
            [
                'locale_fallbacks'  => ['en-us']
            ]
        );

        // Loading service container
        $this->register(new DiContainerProvider());
    }

    /**
     * Load local listeners and put on DI container
     *
     * @return void
     */
    private function listeners()
    {
        foreach ($this['config']['listeners'] as $eventName => $classService) {
            $this['dispatcher']->addListener($classService::NAME, [new $classService($this), 'dispatch']);
        }
    }

    /**
     * Load local translations files
     *
     * @return void
     */
    private function translations()
    {
        $this['translator'] = $this->share($this->extend('translator', function ($translator) {
            $translator->addLoader('yaml', new TranslationFileLoader());

            $translator->addResource('yaml', 'config/locales/pt-br.yml', 'pt-br');
            $translator->addResource('yaml', 'config/locales/en-us.yml', 'en-us');
            $translator->addResource('yaml', 'config/locales/es-es.yml', 'es-es');

            return $translator;
        }));
    }

    /**
     * Load local services providers
     *
     * @return void
     */
    private function providers()
    {
        $this->register(new CorsServiceProvider());
        $this->register(new HmacServiceProvider());
    }
}
