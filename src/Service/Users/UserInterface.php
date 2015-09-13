<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Service\Users;

use Skel\Entity\Users\UserInterface as UserModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface UserInterface
{
    /**
     * @const string
     */
    const NAME = 'users.user.service';

    /**
     * @param  UserModel $user
     *
     * @return UserModel
     */
    public function save(UserModel $user);

    /**
     * @param  UserModel $user
     *
     * @return boolean
     */
    public function delete(UserModel $user);

    /**
     * Update profile
     *
     * @param UserModel $user
     * @param Request $request
     * @return mixed
     */
    public function update(UserModel $user, Request $request);

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return ProfileModel
     */
    public function findById($id);
}
