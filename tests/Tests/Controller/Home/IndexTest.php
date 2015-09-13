<?php
/**
 * @author Thiago Paes <mrprompt@gmail.com>
 * @copyright free
 */
namespace Skel\Tests\Controller\Home;

use Skel\Tests\ApplicationTestCase;

/**
 * Home Controller Test Case
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class IndexTest extends ApplicationTestCase
{
    /**
     * @test
     */
    public function getHome()
    {
        $client = $this->createClient();
        $client->request('GET', '/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putHome()
    {
        $client = $this->createClient();
        $client->request('PUT', '/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteHome()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postHome()
    {
        $client = $this->createClient();
        $client->request('POST', '/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }
}
