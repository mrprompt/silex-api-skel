<?php
declare(strict_types = 1);

namespace User\Tests\Mock\Service;

use User\Service\UserInterface;
use Mockery as m;

/**
 * User Service Mock
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class User
{
    /**
     * @return m\MockInterface
     */
    public static function getMock()
    {
        $user = m::mock(UserInterface::class);
        $user->shouldReceive('save')->andReturn(true)->byDefault();
        $user->shouldReceive('delete')->andReturn(true)->byDefault();
        $user->shouldReceive('update')->andReturn(true)->byDefault();
        $user->shouldReceive('findByUserId')->andReturn(true)->byDefault();
        $user->shouldReceive('listAll')->andReturn(true)->byDefault();

        return $user;
    }
}
