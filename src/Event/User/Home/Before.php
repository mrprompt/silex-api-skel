<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Event\User\Home;

use Skel\Bootstrap;

/**
 * Connection created event
 *
 * @author Romeu Mattos <romeu.smattos@gmail.com>
 */
final class Before
{
    /**
     * @var string
     */
    const NAME = 'user.home.before';

    /**
     * @var Bootstrap
     */
    private $app;

    /**
     * Constructor
     *
     * @param Bootstrap $app
     */
    public function __construct(Bootstrap $app)
    {
        $this->app = $app;
    }

    /**
     * Execute listener
     *
     * @return void
     */
    public function dispatch()
    {
        // :)
    }
}
