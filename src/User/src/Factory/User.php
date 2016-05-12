<?php
declare(strict_types = 1);

namespace User\Factory;

use User\Entity\User as UserModel;

/**
 * The User Factory
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class User
{
    /**
     * Create user object
     *
     * @param string $name
     * @param string $email
     * @return UserModel
     */
    public static function create(string $name, string $email): UserModel
    {
        $user = new UserModel();
        $user->setName($name);
        $user->setEmail($email);

        return $user;
    }

    /**
     * Update user object
     *
     * @param UserModel $user
     * @param string $name
     * @param string $email
     * @return UserModel
     */
    public static function update(UserModel $user, string $name, string $email): UserModel
    {
        $user->setName($name);
        $user->setEmail($email);

        return $user;
    }
}
