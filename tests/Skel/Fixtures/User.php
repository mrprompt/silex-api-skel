<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Skel\Entity\Users\User as UserModel;

/**
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 1;

        while ($i <= 10) {
            $user = [
                'id' => $i,
                'status' => UserModel::ACTIVE,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@users.net',
                'password' => 'user' . $i . '@users.net',
            ];

            $obj = new UserModel();
            $obj->setName($user['name']);
            $obj->setEmail($user['email']);
            $obj->setPassword($user['password']);
            $obj->setStatus($user['status']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('user_' . $user['id'], $obj);

            $i++;
        }
    }

    /**
     * Load order
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
