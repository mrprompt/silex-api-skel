<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Providers\Cors;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cross-Origin Resource Sharing
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
final class Cors implements CorsInterface, ServiceProviderInterface
{
    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        /**
         * Add the
         */
        $app[self::HTTP_CORS] = $app->protect(
            function (Request $request, Response $response) use ($app) {
                $response->headers->set("Access-Control-Max-Age", "86400");
                $response->headers->set("Access-Control-Allow-Origin", "*");

                return $response;
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {
        $app->flush();

        /* @var $routes \Symfony\Component\Routing\RouteCollection */
        $routes = $app['routes'];

        /* @var $route \Silex\Route */
        foreach ($routes->getIterator() as $id => $route) {
            $path = $route->getPath();

            $headers = implode(',', [
                'Authorization',
                'Accept',
                'X-Request-With',
                'Content-Type',
                'X-Session-Token',
                'X-Hmac-Hash',
                'X-Time',
                'X-Url'
            ]);

            /* @var $controller \Silex\Controller */
            $controller = $app->match(
                $path,
                function () use ($headers) {
                    return new Response(
                        null,
                        204,
                        [
                            "Allow" => "GET,POST,PUT,DELETE",
                            "Access-Control-Max-Age" => 84600,
                            "Access-Control-Allow-Origin" => "*",
                            "Access-Control-Allow-Credentials" => "false",
                            "Access-Control-Allow-Methods" => "GET,POST,PUT,DELETE",
                            "Access-Control-Allow-Headers" => $headers
                        ]
                    );
                }
            );

            $controller->method('OPTIONS');

            /* @var $controllerRoute \Silex\Route */
            $controllerRoute = $controller->getRoute();
            $controllerRoute->setCondition($route->getCondition());
            $controllerRoute->setSchemes($route->getSchemes());
            $controllerRoute->setMethods('OPTIONS');
        }
    }
}
