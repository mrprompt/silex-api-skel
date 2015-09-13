<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Tests\Service\Users;

use Skel\Service\Users\User as UserService;
use Skel\Mocks\Repository\Users\User as CreateUserRepositoryMock;
use Skel\Mocks\Entity\Users\User as CreateUserEntityMock;
use Skel\Mocks\Database as CreateEmMock;
use Skel\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * User service test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    use CreateEmMock;
    use ChangeProtectedAttribute;
    use CreateUserRepositoryMock;
    use CreateUserEntityMock;

    /**
     * @var UserService
     */
    private $service;

    /**
     * Bootstrap
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->service = new UserService($this->getDefaultEmMock(), $this->userRepositoryMock());
    }

    /**
     * Shutdown
     *
     * @return void
     */
    public function tearDown()
    {
        $this->service = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers Skel\Service\Users\User::save()
     */
    public function save()
    {
        $userModel = $this->userMock();

        $result = $this->service->save($userModel);

        $this->assertSame($userModel, $result);
    }

    /**
     * @test
     * @covers Skel\Service\Users\User::delete()
     */
    public function delete()
    {
        $userModel = $this->userMock();

        $result = $this->service->delete($userModel);

        $this->assertTrue($result);
    }
}
