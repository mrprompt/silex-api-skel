<?php
declare(strict_types = 1);

namespace User\Repository;

use User\Entity\User as UserModel;

/**
 * User Repository interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface UserInterface
{
    /**
     * Get active user
     *
     * @param int $id
     * @return UserModel
     */
    public function findById(int $id): UserModel;

    /**
     * List all active users
     *
     * @return array
     */
    public function findAll(): array;
}
