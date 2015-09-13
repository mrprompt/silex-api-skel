<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Mocks;

use Mockery as m;

/**
 * Create Entity Manager Mock
 *
 * @author Elton Minetto <eminetto@gmail.com>
 * @author Thiago Paes <mrprompt@gmail.com>
 */
trait Database
{
    /**
     * @codeCoverageIgnore
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * @codeCoverageIgnore
     * @return Ambigous <boolean, \Skel\\Tests\Ambigous>
     */
    public static function getDefaultEmMock($entity = null)
    {
        $qbMock         = self::buildQbMock();

        $repositoryMock = self::buildRepositoryMock();

        $connMock       = self::buildConnectionMock();

        $emMock         = self::buildEmMock($repositoryMock, $qbMock, $connMock, $entity);

        return $emMock;
    }

    /**
     * @codeCoverageIgnore
     * @return Ambigous <\Mockery\MockInterface, Yay_MockObject>
     */
    public static function buildQbMock()
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
        $qbMock->shouldReceive('getOneOrNullResult')->andReturn([])->byDefault();
        $qbMock->shouldReceive('orWhere')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('orderBy')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('setFirstResult')->andReturn($qbMock)->byDefault();
        $qbMock->shouldReceive('setMaxResults')->andReturn($qbMock)->byDefault();

        return $qbMock;
    }

    /**
     * @codeCoverageIgnore
     * @return Ambigous <\Mockery\MockInterface, Yay_MockObject>
     */
    public static function buildConnectionMock()
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
    public static function buildEmMock($repositoryMock = null, $qbMock = null, $connMock = null, $entity = null)
    {
        $repositoryMock = self::buildRepositoryMock();
        $qbMock = self::buildQbMock();

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
    public static function buildRepositoryMock($entity = null)
    {
        // getRepository()->findOneBy() should return an instance of the parameter sent to getRepository()
        $repositoryMock = m::mock('Doctrine\ORM\EntityRepository');

        $repositoryMock->shouldReceive('findOneBy')
            ->andReturnUsing(function ($params) use (&$entity) {
                if ($entity === null) {
                    return ;
                }

                $object = new $entity();

                foreach ($params as $key => $value) {
                    $setMethod = 'set' . ucfirst($key);
                    $object->$setMethod($value);
                }

                return $object;
            })->byDefault();

        $repositoryMock->shouldReceive('findBy')
            ->andReturnUsing(function ($params) use (&$entity) {
                if ($entity === null) {
                    return ;
                }

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

                if ($entity === null) {
                    return ;
                }

                $object = new $entity();

                return $object;
            })->byDefault();

        $repositoryMock->shouldReceive('findOneById')
            ->andReturnUsing(function ($params) use (&$entity) {
                if ($params == -1) {
                    return null;
                }

                if ($entity === null) {
                    return ;
                }

                $object = new $entity();

                return $object;
            })->byDefault();

        $repositoryMock->shouldReceive('findAll')
            ->andReturnUsing(function () use (&$entity) {
                if ($entity === null) {
                    return [];
                }

                $object = new $entity();

                return [$object];
            })->byDefault();

        $repositoryMock->shouldReceive('createQueryBuilder')
            ->andReturn(self::buildQbMock())
            ->byDefault();

        return $repositoryMock;
    }
}
