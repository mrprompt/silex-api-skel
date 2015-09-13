<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Service\Users;

use Skel\Entity\EntityInterface;
use Skel\Service\Service;
use Skel\Entity\Users\UserInterface as UserModel;
use Skel\Repository\Users\UserInterface as UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Skel\Factory\Users\User as UserFactory;

/**
 * User Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @author Romeu Mattos <romeu.smattos@gmail.com>
 */
final class User extends Service implements UserInterface
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @param EntityManagerInterface $em
     * @param UserRepository $users
     */
    public function __construct(EntityManagerInterface $em, UserRepository $users)
    {
        parent::__construct($em);

        $this->users        = $users;
    }

    /**
     * @param  UserModel $user
     * @return UserModel
     */
    public function save(UserModel $user)
    {
        $this->em->getConnection()->beginTransaction();

        try {
            $this->em->persist($user);
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (UniqueConstraintViolationException $ex) {
            $this->em->getConnection()->rollBack();

            $error = sprintf(
                'This email/nickname "%s/%s" is already registered',
                $user->getEmail(),
                $user->getProfile()->getNickname()
            );

            throw new InvalidArgumentException($error, 409, $ex);
        } catch (Exception $ex) {
            $this->em->getConnection()->rollBack();

            throw new InvalidArgumentException($ex->getMessage(), 500, $ex);
        }

        return $user;
    }

    /**
     * @param  UserModel $user
     * @return boolean
     */
    public function delete(UserModel $user)
    {
        $user->setStatus(EntityInterface::DELETED);

        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * Update profile
     *
     * @param UserModel $user
     * @param Request $request
     * @return mixed
     */
    public function update(UserModel $user, Request $request)
    {
        /* @var $update \Skel\Entity\Users\User */
        $update = UserFactory::update($user, $request);

        return $this->save($update);
    }

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return ProfileModel
     */
    public function findById($id)
    {
        $user = $this->users->findById($id);

        return $user;
    }

    /**
     * List all profiles
     *
     * @return array|mixed
     */
    public function findAll()
    {
        $users = $this->users->findAll();

        return $users;
    }
}
