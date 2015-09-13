<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Mocks\Repository\Users;

use Skel\Repository\Users\UserInterface;
use Mockery as m;

/**
 * User Entity Mock
 *
 * @author Romeu Mattos <romeu.smattos@gmail.com>
 */
trait User
{
    public function userRepositoryMock()
    {
        $user = m::mock(UserInterface::class);
        $user->shouldReceive('findById')->andReturn($this->userMock())->byDefault();

        return $user;
    }
}