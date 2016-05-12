<?php
declare(strict_types = 1);

namespace User\Service;

use User\Entity\User as UserModel;
use Doctrine\ORM\EntityManagerInterface;

/**
 * User Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface UserInterface
{
    /**
     * User Service Constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em);

    /**
     * @param  UserModel $user
     * @return UserModel
     */
    public function save(UserModel $user): UserModel;

    /**
     * @param  UserModel $user
     * @return UserModel
     */
    public function delete(UserModel $user): UserModel;

    /**
     * Find one by user id
     *
     * @param  int $id id
     * @return UserModel
     */
    public function findByUserId(int $id): UserModel;

    /**
     * List all users
     *
     * @return array
     */
    public function listAll(): array;

    /**
     * Create an user
     *
     * @param string $name
     * @param string $email
     * @return UserModel
     */
    public function create(string $name, string $email): UserModel;

    /**
     * Update an user
     *
     * @param UserModel $user
     * @param string $name
     * @param string $email
     * @return UserModel
     */
    public function update(UserModel $user, string $name, string $email): UserModel;
}
