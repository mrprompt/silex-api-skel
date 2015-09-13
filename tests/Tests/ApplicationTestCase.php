<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license proprietary
 */
namespace Skel\Tests;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\QueryException;
use Silex\WebTestCase;

/**
 * Application Test Suite Bootstrap
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class ApplicationTestCase extends WebTestCase
{
    /**
     * @var \Silex\Application
     */
    protected static $application;

    protected $header        = [
        'HTTP_Content-type'     => 'application/json',
        'HTTP_Authorization'    => 'TOKEN 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a',
    ];

    /**
     * Test bootstrap
     *
     * @return \Silex\Application
     */
    public function createApplication()
    {
        $this->app                  = require 'bootstrap.php';
        $this->app['debug']         = false;
        $this->app['session.test']  = false;
        $this->app['testing']       = true;

        self::$application = $this->app;

        return $this->app;
    }

    /**
     * Test suite cleanup
     */
    public static function tearDownAfterClass()
    {
        self::$application['logger']->addDebug('Rollbacking database...');

        /* $var $repository \Doctrine\ORM\Mapping\ClassMetadata[] */
        $metadata = self::$application['orm.em']->getMetadataFactory()->getAllMetadata();

        /* $var $repository \Doctrine\ORM\Mapping\ClassMetadata */
        foreach ($metadata as $repository) {
            $entity = $repository->getName();

            $dql = sprintf('UPDATE %s a SET a.status = \'%d\' WHERE a.status IN (%s) AND a.updated != a.created', $entity, 2, implode(',', [3, 4, 5, 6]));

            try {
                /* @var $run \Doctrine\ORM\Query */
                $run = self::$application['orm.em']->createQuery($dql);
                $run->execute();

                self::$application['logger']->addDebug(sprintf('DQL: %s', $dql));
            } catch (QueryException $qe) {
                // :(
            }
        }

        try {
            self::$application['orm.em']->flush();
        } catch (ORMException $oex) {
            // :)
        }
    }
}
