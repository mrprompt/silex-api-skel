<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Controller\Users;

use Skel\Bootstrap as Application;
use Skel\Response as View;
use Skel\Service\Users\User as UserService;
use Skel\Factory\Users\User as UserFactory;

/**
 * User Controller
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User implements UserInterface
{
    /**
     * GET Request for /user/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app)
    {
        $users = $app[UserService::NAME]->findAll();

        return new View($users, View::HTTP_OK);
    }

    /**
     * GET request for /user/{id}
     *
     * @param  Application $app
     * @return View
     */
    public function view(Application $app)
    {
        $user = $app[UserService::NAME]->findById($app['request']->get('id'));

        return new View($user, View::HTTP_OK);
    }

    /**
     * PUT request route for /user/{id}
     *
     * @param  Application $app
     * @return View
     */
    public function update(Application $app)
    {
        $app['user'] = $app[UserService::NAME]->findById($app['request']->get('id'));

        $user = $app[UserService::NAME]->update($app['user'], $app['request']);

        return new View($user, View::HTTP_NO_CONTENT);
    }

    /**
     * DELETE request route for /user/{id}
     *
     * @param  Application $app
     * @return View
     */
    public function delete(Application $app)
    {
        $app['user'] = $app[UserService::NAME]->findById($app['request']->get('id'));

        $user = $app[UserService::NAME]->delete($app['user']);

        return new View($user, View::HTTP_NO_CONTENT);
    }

    /**
     * Create an user
     *
     * @param  Application $app
     * @param  Request $app['request']
     * @return View
     */
    public function create(Application $app)
    {
        $app['user'] = UserFactory::create($app['request']);

        $user = $app[UserService::NAME]->save($app['user']);

        return new View($user, View::HTTP_CREATED);
    }
}
