<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Event\User;

use Symfony\Component\EventDispatcher\Event;

/**
 * Connection created event
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class Create
{
    /**
     * @var string
     */
    const NAME = 'events.user.create';

    /**
     * @var Application
     */
    private $app;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Execute listener
     *
     * @return void
     */
    public function dispatch(Event $event)
    {
        $this->app['monolog']->addDebug('executando chamada de ' . self::NAME);
    }
}
