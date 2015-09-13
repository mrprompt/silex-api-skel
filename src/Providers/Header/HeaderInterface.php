<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Providers\Header;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
interface HeaderInterface
{
    /**
     * Header authorization index
     *
     * @const string
     */
    const TOKEN_HEADER_KEY      = 'Authorization';

    /**
     * Header request key index
     *
     * @const string
     */
    const TOKEN_REQUEST_KEY     = '_token';

    /**
     * @var string
     */
    const HTTP_HEADER_GET_TOKEN = 'service.http.header';
}
