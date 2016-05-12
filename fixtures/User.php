<?php
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use User\Entity\User as UserModel;

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
        $i      = 1;
        $user   = [
            'name' => 'User ' . $i,
            'email' => 'user' . $i . '@users.net',
        ];

        $obj = new UserModel();
        $obj->setName($user['name']);
        $obj->setEmail($user['email']);

        $manager->persist($obj);
        $manager->flush();

        $this->addReference('user_' . $i, $obj);
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
