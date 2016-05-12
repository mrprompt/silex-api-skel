<?php
declare(strict_types = 1);

namespace User\Tests\Service;

use Common\ChangeProtectedAttribute;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Tests\OrmTestCase;
use User\Entity\User;
use User\Entity\UserInterface;
use User\Service\User as UserService;
use User\Tests\Mock\Repository\User as CreateUserRepositoryMock;

/**
 * User service test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserTest extends OrmTestCase
{
    use ChangeProtectedAttribute;

    /**
     * @var UserService
     */
    private $obj;

    /**
     * Boot
     */
    public function setUp()
    {
        parent::setUp();

        $reader = new AnnotationReader();
        $metadataDriver = new AnnotationDriver($reader, User::class);

        $em = $this->_getTestEntityManager();
        $em->getConfiguration()->setMetadataDriverImpl($metadataDriver);

        $this->obj = new UserService($em);

        $this->modifyAttribute($this->obj, 'users', CreateUserRepositoryMock::getMock());
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->obj = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \User\Service\User::save()
     */
    public function saveMustBeReturnSameObject()
    {
        $userModel = new User();

        $result = $this->obj->save($userModel);

        $this->assertSame($userModel, $result);
    }

    /**
     * @test
     * @covers \User\Service\User::delete()
     */
    public function deleteMustBeReturnSameObject()
    {
        $userModel = new User();

        $result = $this->obj->delete($userModel);

        $this->assertSame($userModel, $result);
    }

    /**
     * @test
     * @covers \User\Service\User::findByUserId()
     */
    public function findByUserIdMustBeReturnUserInterface()
    {
        $result = $this->obj->findByUserId(1);

        $this->assertInstanceOf(UserInterface::class, $result);
    }

    /**
     * @test
     * @covers \User\Service\User::listAll()
     */
    public function listAllMustBeReturnArray()
    {
        $result = $this->obj->listAll();

        $this->assertTrue(is_array($result));
    }

    /**
     * @test
     */
    public function updateMustBeReturnSameObject()
    {
        $user = new User();

        $result = $this->obj->update($user, 'foo', 'foo@bar.bar');

        $this->assertInstanceOf(UserInterface::class, $result);
    }

    /**
     * @test
     */
    public function createMustBeReturnUserObject()
    {
        $result = $this->obj->create('Foo', 'foo@foo.net');

        $this->assertInstanceOf(UserInterface::class, $result);
    }
}
