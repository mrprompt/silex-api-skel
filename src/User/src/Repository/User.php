<?php
declare(strict_types = 1);

namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\User as UserModel;

/**
 * User Repository
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class User extends EntityRepository implements UserInterface
{
    /**
     * @inheritdoc
     */
    public function findById(int $id): UserModel
    {
        $user = $this->findOneBy(
            [
                'id' => $id,
                'active' => true
            ]
        );

        if (null === $user) {
            $user = new UserModel();
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        $users = $this->findBy(
            [
                'active' => true
            ]
        );

        return $users;
    }
}
