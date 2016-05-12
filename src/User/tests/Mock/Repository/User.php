<?php
declare(strict_types = 1);

namespace User\Tests\Mock\Repository;

use User\Repository\UserInterface;
use User\Entity\User as UserModel;
use Mockery as m;

/**
 * User Repository Mock
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
        $userModel = new UserModel();
        
        $user = m::mock(UserInterface::class);
        $user->shouldReceive('findById')->andReturn($userModel)->byDefault();
        $user->shouldReceive('findAll')->andReturn([$userModel])->byDefault();

        return $user;
    }
}
