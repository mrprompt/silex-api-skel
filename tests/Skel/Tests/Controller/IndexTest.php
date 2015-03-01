<?php
/**
 * @author Thiago Paes <mrprompt@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller;

use Skel\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class IndexTest extends WebTestCase
{
    use ApplicationControllerTestCase;

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
