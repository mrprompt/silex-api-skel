<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Mocks;

use Mockery;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\AttributeBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Http Request Object Mock
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
trait Request
{
    public function createRequestMock()
    {
        $mock = Mockery::mock(HttpRequest::class);
        $mock->shouldReceive('getClientIp')
            ->andReturn('::1')
            ->byDefault();

        $headerbag = Mockery::mock(HeaderBag::class);
        $headerbag
            ->shouldReceive('get')
            ->with('date')
            ->andReturn((new \DateTime())->format('Y-m-d'))
            ->byDefault();

        $headerbag
            ->shouldReceive('get')
            ->with('Content-Type')
            ->andReturn('application/json')
            ->byDefault();

        $headerbag
            ->shouldReceive('get')
            ->with('User-Agent')
            ->andReturn('Mock Agent')
            ->byDefault();

        $attributeBag = Mockery::mock(AttributeBag::class);
        $attributeBag
            ->shouldReceive('set')
            ->andReturnSelf()
            ->byDefault();

        $attributeBag = Mockery::mock(AttributeBag::class);
        $attributeBag
            ->shouldReceive('get')
            ->andReturnSelf()
            ->byDefault();

        $attributeBag
            ->shouldReceive('has')
            ->andReturn(true)
            ->byDefault();

        $mock->headers = $headerbag;
        $mock->attributes = $attributeBag;

        return $mock;
    }
}