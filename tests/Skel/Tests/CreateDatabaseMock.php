<?php
namespace Skel\Tests;

use Mockery as m;

/**
 * Create Entity Manager Mock
 *
 * @author Elton Minetto
 */
trait CreateDatabaseMock
{
    protected $repositoryMock;
    protected $emMock;
    protected $qbMock;
    protected $entity = '';

    /**
     * @codeCoverageIgnore
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * @codeCoverageIgnore
     * @return Ambigous <boolean, \Skel\Tests\Ambigous>
     */
    protected function getDefaultEmMock()
    {
        if ($this->emMock) {
            return $this->emMock;
        }

        $this->qbMock = $this->buildQbMock();

        $this->repositoryMock = $this->buildRepositoryMock();

        $this->connMock = $this->buildConnectionMock();

        $this->emMock = $this->buildEmMock($this->repositoryMock, $this->qbMock, $this->connMock);

        return $this->emMock;
    }

    /**
     * @codeCoverageIgnore
     * @return Ambigous <\Mockery\MockInterface, Yay_MockObject>
     */
    protected function buildQbMock()
    {
        $qbMock = m::mock('Doctrine\ORM\QueryBuilder');
        $qbMock->shouldReceive('select')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('join')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('where')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('andWhere')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('setParameter')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('setParameters')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('getQuery')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('getResult')->andReturn([])->byDefault();
        $qbMock->shouldReceive('orWhere')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('orderBy')->andReturn($qbMock)->byDefault();

        return $qbMock;
    }

    /**
     * @codeCoverageIgnore
     * @return Ambigous <\Mockery\MockInterface, Yay_MockObject>
     */
    protected function buildConnectionMock()
    {
        $connMock = m::mock('Doctrine\DBAL\Connection');

        $connMock->shouldReceive('beginTransaction')
            ->andReturn(true)
            ->byDefault();

        $connMock->shouldReceive('commit')
            ->andReturn(true)
            ->byDefault();

        $connMock->shouldReceive('rollBack')
            ->andReturn(true)
            ->byDefault();

        return $connMock;
    }

    /**
     * @codeCoverageIgnore
     * @param string $repositoryMock
     * @param string $qbMock
     * @param string $connMock
     * @return boolean|Ambigous <\Mockery\MockInterface, Yay_MockObject>
     */
    protected function buildEmMock($repositoryMock = null, $qbMock = null, $connMock = null)
    {
        $entity =& $this->entity;

        if (!$repositoryMock)
            $repositoryMock = $this->buildRepositoryMock();

        if (!$qbMock)
            $qbMock = $this->buildQbMock();

        $emMock = m::mock('Doctrine\ORM\EntityManager');

        $emMock->shouldReceive('persist')
            ->andReturn(null)
            ->byDefault();

        $emMock->shouldReceive('flush')
            ->andReturn(null)
            ->byDefault();

        $emMock->shouldReceive('getClassMetadata')
            ->andReturn((object)array('name' => &$entity))
            ->byDefault();

        $emMock->shouldReceive('getRepository')
            ->with(m::on(function ($entityName) use (&$entity) {
                $entity = '\\' . $entityName;
                return true;
            }))
            ->andReturn($repositoryMock)
            ->byDefault();

        $emMock->shouldReceive('createQueryBuilder')
            ->andReturn($qbMock)
            ->byDefault();

        $emMock->shouldReceive('getConnection')
            ->andReturn($connMock)
            ->byDefault();

        return $emMock;
    }

    /**
     * @codeCoverageIgnore
     * @return unknown|NULL|Ambigous <\Mockery\MockInterface, Yay_MockObject>
     */
    protected function buildRepositoryMock()
    {
        $entity =& $this->entity;

        // getRepository()->findOneBy() should return an instance of the parameter sent to getRepository()
        $repositoryMock = m::mock('Doctrine\ORM\EntityRepository');

        $repositoryMock->shouldReceive('findOneBy')
            ->andReturnUsing(function ($params) use (&$entity) {
                $object = new $entity();

                foreach ($params as $key => $value) {
                    $setMethod = 'set' . ucfirst($key);
                    $object->$setMethod($value);
                }

                return $object;
            })->byDefault();

        $repositoryMock->shouldReceive('findBy')
            ->andReturnUsing(function ($params) use (&$entity) {
                $object = new $entity();
                foreach ($params as $key => $value) {
                    $setMethod = 'set' . ucfirst($key);
                    $object->$setMethod($value);
                }
                return $object;
            })->byDefault();

        $repositoryMock->shouldReceive('find')
            ->andReturnUsing(function ($params) use (&$entity) {
                if ($params == -1) {
                    return null;
                }
                $object = new $entity();
                return $object;
            })->byDefault();

        $repositoryMock->shouldReceive('createQueryBuilder')
            ->andReturn($this->buildQbMock())
            ->byDefault();

        $repositoryMock->shouldReceive('findOneByUser')
            ->andReturn(m::mock('Domain\Entity\Users\User'))
            ->byDefault();

        return $repositoryMock;
    }
}
