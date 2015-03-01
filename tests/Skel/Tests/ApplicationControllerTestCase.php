<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Tests;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
trait ApplicationControllerTestCase
{
    protected $header = [
        'HTTP_Content-type' => 'application/json',
    ];

    /**
     * App Boostrap
     *
     * @return \Silex\Application
     */
    public static function getBootstrap()
    {
        chdir(__DIR__ . '/../../../');

        $app = require 'bootstrap.php';

        return $app;
    }

    /**
     * Pré-teste
     *
     * @return \Silex\Application
     */
    public static function createApplication()
    {
        $app = self::getBootstrap();

        $app['debug'] = true;
        $app['session.test'] = false;
        $app['exception_handler']->disable();

        return $app;
    }
}
