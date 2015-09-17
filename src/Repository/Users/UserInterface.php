<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Repository\Users;

use Skel\Repository\Repository;

/**
 * User Repository Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface UserInterface
{
    /**
     * Find user by e-mail
     *
     * @param string $email
     */
    public function findByEmail($email);
}
