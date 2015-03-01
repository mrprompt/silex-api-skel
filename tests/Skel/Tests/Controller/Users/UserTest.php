<?php
/**
 * @author Thiago Paes <mrprompt@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Users;

use Skel\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 * User Controller test case
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        return [
            [
                [
                    "name" => sha1(uniqid()),
                    "email" => sha1(uniqid()) . "@teste.net",
                    "password" => sha1(uniqid()),
                ]
            ],
        ];
    }

    /**
     * @test
     */
    public function getAllUsers()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserById()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/1', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByIdThrowsExceptionWhenUserIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function putUserWithFullParameters($obj)
    {
        $client = $this->createClient();
        $client->request('PUT', '/user/1', $obj, [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putUserWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('PUT', '/user/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteUserWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/user/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteUser()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/user/1', [], [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
