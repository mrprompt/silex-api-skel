<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Providers\Hmac;

use Mardy\Hmac\Adapters\HashHmac;
use Mardy\Hmac\Manager;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * HMAC validation service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
final class Hmac implements HmacInterface, ServiceProviderInterface
{
    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app[self::HMAC_VALIDATE_REQUEST] = $app->protect(
            function (Request $request, $token = null) use ($app) {
                $method = $request->getMethod();
                $content = $request->getContent();

                /* @var $user UserModel */
                $user = $app->offsetExists('user') ? $app['user'] : null;

                /**
                 * Getting variables
                 */
                $time = filter_var($request->headers->get('x-time'), FILTER_SANITIZE_NUMBER_INT);
                $url  = filter_var($request->headers->get('x-url'), FILTER_SANITIZE_URL);
                $hmac = filter_var($request->headers->get('x-hmac-hash'), FILTER_SANITIZE_STRING);

                /**
                 * For GET requests, this takes the form:
                 * {{REQUEST_METHOD}}{{HTTP_HOST}}{{REQUEST_URI}}
                 *
                 * For POST requests, this would be:
                 * {{REQUEST_METHOD}}{{HTTP_HOST}}{{REQUEST_URI}}{{RAW_POST_DATA}}
                 *
                 * And for PUT requests, this would be:
                 * {{REQUEST_METHOD}}{{HTTP_HOST}}{{REQUEST_URI}}{{RAW_PUT_DATA}}
                 */
                $data = "{$method}:{$url}" . (!empty($content) ? ":{$content}" : '');

                /**
                 * If $user is null, this request is for login probably
                 */
                if ($user === null) {
                    $key  = hash('sha512', "{$data}:{$time}");
                } else {
                    // Getting user email
                    $email = $user->getEmail();

                    $key = hash('sha512', "{$email}:{$token}");
                }

                $manager = new Manager(new HashHmac());
                $manager->config([
                    'algorithm' => 'sha512',
                    'num-first-iterations' => 10,
                    'num-second-iterations' => 10,
                    'num-final-iterations' => 100,
                ]);

                //time to live, when checking if the hmac isValid this will ensure
                //that the time with have to be with this number of seconds
                $manager->ttl(2);

                //the current timestamp, this will be compared in the other API to ensure
                $manager->time($time);

                //the secure private key that will be stored locally and not sent in the http headers
                $manager->key($key);

                //the data to be encoded with the hmac, you could use the URI for this
                $manager->data($data);

                //to check if the hmac is valid you need to run the isValid() method
                //this needs to be executed after the encode method has been ran
                return $manager->isValid($hmac);
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // :)
    }
}
