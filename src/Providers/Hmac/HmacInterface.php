<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Providers\Hmac;

/**
 * HMAC validation service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
interface HmacInterface
{
    /**
     * @var string
     */
    const HMAC_VALIDATE_REQUEST = 'service.http.hmac';
}
