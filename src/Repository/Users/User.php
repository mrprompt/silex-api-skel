<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Repository\Users;

use Skel\Entity\Users\User as UserModel;
use Skel\Repository\Repository;
use OutOfRangeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User extends Repository implements UserInterface
{
    /**
     * @see \Skel\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $users = $this->em->getRepository('Skel\Entity\Users\User')->findBy([
            'status' => [
                UserModel::NEWER,
                UserModel::ACTIVE
            ]
        ]);

        return $users;
    }

    /**
     * @see \Skel\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $user = $this->em->getRepository('Skel\Entity\Users\User')->findOneBy([
            'id' => $id,
            'status' => [
                UserModel::NEWER,
                UserModel::ACTIVE
            ]
        ]);

        if (null === $user || $user->isDeleted()) {
            throw new OutOfRangeException('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * Find an user by email
     *
     * @param  string $email
     * @throws OutOfRangeException
     * @return UserModel
     */
    public function findByEmail($email)
    {
        /* @var $user UserModel */
        $user = $this->em->getRepository('Skel\Entity\Users\User')->findOneBy(
            [
                'email' => $email,
                'status' => [
                    UserModel::NEWER,
                    UserModel::ACTIVE
                ]
            ]
        );

        if (null === $user || $user->isDeleted()) {
            throw new OutOfRangeException('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }
}
