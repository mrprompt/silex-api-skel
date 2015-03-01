<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Service\Users;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Domain\Entity\Users\User as UserModel;
use Domain\Service\Users\User as UserServiceInterface;
use Skel\Repository\Users\User as UserRepository;
use Skel\Factory\Users\User as UserFactory;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User implements UserServiceInterface
{
    /**
     * @const string
     */
    const USER_USER = 'service.users.user';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $service = $this;

        $this->em = $app['orm.em'];

        $app[self::USER_USER] = $service;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param  UserModel $user
     * @return UserModel
     */
    public function save(UserModel $user)
    {
        try {
            $this->em->persist($user);
        } catch (UniqueConstraintViolationException $ex) {
            throw new InvalidArgumentException('This email is already registered', 409, $ex);
        }

        return $user;
    }

    /**
     * @param  UserModel $user
     * @return boolean
     */
    public function delete(UserModel $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('This user is already deleted');
        }

        $user->setStatus(UserModel::DELETED);

        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return UserModel
     */
    public function findByUserId($id)
    {
        $repo = new UserRepository($this->em);
        $user = $repo->findById($id);

        return $user;
    }

    /**
     * Find one by user id
     *
     * @param int $id  id
     * @return UserModel[]
     */
    public function listAll()
    {
        $repo = new UserRepository($this->em);
        $users = $repo->findAll();

        return $users;
    }

    /**
     * Update user
     *
     * @param $id
     * @param Request $request
     * @return bool
     */
    public function update($id, Request $request)
    {
        $user = $this->findByUserId($id);

        $update = UserFactory::update($user, $request);

        $this->save($update);

        return true;
    }

    /**
     * Removes an user
     *
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        $user = $this->findByUserId($id);

        $this->delete($user);

        return true;
    }

    /**
     * @param Request $request
     * @return \Skel\Entity\Users\User
     */
    public function create(Request $request)
    {
        /* @var $user \Skel\Entity\Users\User */
        $user = UserFactory::create($request);

        $this->save($user);

        return $user;
    }
}
