<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Factory\Users;

use Skel\Entity\Users\User as UserModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * The User Factory
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
abstract class User
{
    /**
     *
     * @param Request $user
     * @return UserModel
     */
    public static function create(Request $user)
    {
        $obj = new UserModel();
        $obj->setName($user->get('name'));
        $obj->setEmail($user->get('email'));
        $obj->setPassword($user->get('password'));
        $obj->setStatus(UserModel::NEWER);

        return $obj;
    }

    /**
     *
     * @param UserModel $user
     * @param Request $req
     * @return UserModel
     */
    public static function update(UserModel $user, Request $req)
    {
        $user->setName($req->get('name'));
        $user->setEmail($req->get('email'));
        $user->setStatus(UserModel::ACTIVE);

        return $user;
    }
}
