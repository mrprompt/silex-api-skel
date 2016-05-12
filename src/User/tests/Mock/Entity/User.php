<?php
declare(strict_types = 1);

namespace User\Tests\Mock\Entity;

use User\Entity\UserInterface;
use Mockery as m;

/**
 * User Entity Mock
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
        $user->shouldReceive('getId')->andReturn(1)->byDefault();
        $user->shouldReceive('setName')->andReturnNull()->byDefault();
        $user->shouldReceive('getName')->andReturn('Lorem ipsum')->byDefault();
        $user->shouldReceive('setEmail')->andReturnNull()->byDefault();
        $user->shouldReceive('getEmail')->andReturn('foo@bar.bar')->byDefault();

        return $user;
    }
}
