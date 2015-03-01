<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Domain\Service\Users;

use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Service Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface User extends ServiceProviderInterface
{
    /**
     * @param  \Domain\Entity\Users\User $user
     * @return \Domain\Entity\Users\User
     */
    public function save(UserModel $user);

    /**
     * @param  UserModel $user
     * @return boolean
     */
    public function delete(UserModel $user);

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return UserModel
     */
    public function findByUserId($id);

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return UserModel[]
     */
    public function listAll();

    /**
     * Update user
     *
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function update($id, Request $request);

    /**
     * Removes an user
     *
     * @param $id
     * @return bool
     */
    public function remove($id);

    /**
     * @param Request $request
     * @param UserService $profileService
     * @return UserModel
     */
    public function create(Request $request);
}
