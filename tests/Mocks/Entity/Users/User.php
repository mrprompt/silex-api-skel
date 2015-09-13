<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Mocks\Entity\Users;

use Skel\Entity\Users\UserInterface;
use Mockery as m;

/**
 * User Entity Mock
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
trait User
{
    public function userMock()
    {
        $user = m::mock(UserInterface::class);
        $user->shouldReceive('getId')->andReturn(rand())->byDefault();
        $user->shouldReceive('setStatus')->andReturn(true)->byDefault();
        $user->shouldReceive('setName')->andReturn(true)->byDefault();
        $user->shouldReceive('setEmail')->andReturn(true)->byDefault();
        $user->shouldReceive('getEmail')->andReturn(rand() . '@users.net')->byDefault();

        return $user;
    }
}