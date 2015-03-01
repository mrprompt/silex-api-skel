<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Tests\Service\Users;

use Skel\Entity\Users\User as UserModel;
use Skel\Service\Users\User as UserService;
use Skel\Tests\CreateDatabaseMock as CreateEmMock;
use Skel\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * User service test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see CreateEmMock
     */
    use CreateEmMock;

    /**
     * @see ChangeProtectedAttribute
     */
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Skel\Entity\Users\User::getId()
     * @covers Skel\Entity\Users\User::getPassword()
     * @covers Skel\Entity\Users\User::setPassword()
     * @covers Skel\Entity\Users\User::getName()
     * @covers Skel\Service\Users\User::save()
     * @covers Skel\Entity\Entity::isDeleted()
     * @covers Skel\Entity\Entity::setStatus()
     * @covers Skel\Entity\Entity::setUpdated()
     * @covers Skel\Entity\Entity::setCreated()
     */
    public function save()
    {
        $userService = new UserService();

        $this->modifyAttribute($userService, 'em', $this->getDefaultEmMock());

        $userModel = new UserModel();

        $result = $userService->save($userModel);

        $this->assertSame($userModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Skel\Entity\Entity::setStatus()
     * @covers Skel\Entity\Users\User::setStatus()
     * @covers Skel\Entity\Users\User::isDeleted()
     * @covers Skel\Service\Users\User::delete()
     */
    public function delete()
    {
        $userModel = new UserModel();

        $userService = new UserService();

        $this->modifyAttribute($userService, 'em', $this->getDefaultEmMock());

        $result = $userService->delete($userModel);

        $this->assertTrue($result);
    }
}
