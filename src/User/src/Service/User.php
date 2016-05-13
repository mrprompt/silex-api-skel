<?php
declare(strict_types = 1);

namespace User\Service;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use User\Factory\User as UserFactory;
use User\Entity\User as UserModel;
use Exception;
use InvalidArgumentException;

/**
 * User Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class User implements UserInterface
{
    /**
     * @var \User\Repository\UserInterface
     */
    private $users;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * User Service Constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em       = $em;
        $this->users    = $em->getRepository(UserModel::class);
    }

    /**
     * @inheritdoc
     */
    public function save(UserModel $user): UserModel
    {
        $this->em->beginTransaction();

        try {
            $this->em->persist($user);
            $this->em->flush();
            $this->em->commit();

            return $user;
        } catch (UniqueConstraintViolationException $ex) {
            $this->em->rollBack();

            throw new InvalidArgumentException('Email is already registered', 409, $ex);
        } catch (Exception $ex) {
            $this->em->rollBack();

            throw new InvalidArgumentException($ex->getMessage(), 500, $ex);
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(UserModel $user): UserModel
    {
        $user->delete();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function findByUserId(int $id): UserModel
    {
        return $this->users->findById($id);
    }

    /**
     * @inheritdoc
     */
    public function listAll(): array
    {
        $users = $this->users->findAll();

        return $users;
    }

    /**
     * @inheritdoc
     */
    public function create(string $name, string $email): UserModel
    {
        $user = UserFactory::create($name, $email);

        return $this->save($user);
    }

    /**
     * @inheritdoc
     */
    public function update(UserModel $user, string $name, string $email): UserModel
    {
        /* @var $update \User\Entity\User */
        $update = UserFactory::update($user, $name, $email);

        return $this->save($update);
    }
}
