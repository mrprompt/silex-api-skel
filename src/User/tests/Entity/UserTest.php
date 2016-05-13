<?php
declare(strict_types = 1);

namespace User\Tests\Entity;

use Common\ChangeProtectedAttribute;
use User\Entity\User;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * User test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @return multitype:multitype:number
     */
    public function validObjects()
    {
        $obj = new stdClass();
        $obj->id = 1;
        $obj->name  = 'Teste';
        $obj->email = 'teste@teste.net';

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @return multitype:multitype:number
     */
    public function invalidObjects()
    {
        $obj = new stdClass();
        $obj->id = 'SS';
        $obj->name = '';
        $obj->email = 'lalala';

        return [
            [
                $obj
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \User\Entity\User::setName
     */
    public function setNameReturnEmptyOnSuccess($obj)
    {
        $user = new User();

        $result = $user->setName($obj->name);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider invalidObjects
     * @covers       \User\Entity\User::setName
     * @expectedException \InvalidArgumentException
     */
    public function setNameThrowsExceptionWhenEmpty($obj)
    {
        $user = new User();
        $user->setName($obj->name);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \User\Entity\User::getName
     */
    public function getNameReturnNameAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'name', $obj->name);

        $this->assertEquals($user->getName(), $obj->name);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \User\Entity\User::getEmail
     */
    public function getEmailReturnEmailAttribute($obj)
    {
        $user = new User();

        $this->modifyAttribute($user, 'email', $obj->email);

        $this->assertEquals($user->getEmail(), $obj->email);
    }

    /**
     * @test
     * @dataProvider validObjects
     * @covers       \User\Entity\User::setEmail
     */
    public function setEmailReturnEmptyOnSuccess($obj)
    {
        $user = new User();

        $result = $user->setEmail($obj->email);

        $this->assertEmpty($result);
    }

    /**
     * @test
     * @dataProvider invalidObjects
     * @covers       \User\Entity\User::setEmail
     * @expectedException \InvalidArgumentException
     */
    public function setEmailThrowsInvalidArgumentExceptoinWhenInvalid($obj)
    {
        $user = new User();
        $user->setEmail($obj->email);
    }
}
