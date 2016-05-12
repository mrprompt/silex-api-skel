<?php
declare(strict_types = 1);

namespace User\Tests\Repository;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Tests\OrmTestCase;
use User\Entity\User;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class UserTest extends OrmTestCase
{
    /**
     * @var User
     */
    protected $obj;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Bootstrap
     */
    public function setUp()
    {
        parent::setUp();

        $reader = new AnnotationReader();
        $metadataDriver = new AnnotationDriver($reader, User::class);

        $this->em = $this->_getTestEntityManager();
        $this->em->getConfiguration()->setMetadataDriverImpl($metadataDriver);

        $this->obj = $this->em->getRepository(User::class);
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
     * @covers \User\Repository\User::findAll
     */
    public function findAll()
    {
        $result = $this->obj->findAll();

        $this->assertTrue(is_array($result));
    }

    /**
     * @test
     * @covers \User\Repository\User::findById
     */
    public function findById()
    {
        $result = $this->obj->findById(1);

        $this->assertTrue(is_object($result));
    }
}
