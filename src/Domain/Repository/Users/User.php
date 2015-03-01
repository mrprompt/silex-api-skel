<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Domain\Repository\Users;

use Domain\Repository\Repository;

/**
 * User Repository Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface User extends Repository
{
    /**
     * Find user by e-mail
     *
     * @param string $email
     */
    public function findByEmail($email);
}
