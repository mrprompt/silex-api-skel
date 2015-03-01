<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Controller\Users;

use Skel\Application;
use Skel\View\Json as View;
use Skel\Service\Users\User as UserService;
use Skel\Event\User\Create as CreateEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Controller
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User
{
    /**
     * GET Request for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app)
    {
        $users = $app[UserService::USER_USER]->listAll();

        return new View($users, View::HTTP_OK);
    }

    /**
     * GET request for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request)
    {
        $user = $app[UserService::USER_USER]->findByUserId($request->get('id'));

        return new View($user, View::HTTP_OK);
    }

    /**
     * PUT request route for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function update(Application $app, Request $request)
    {
        $user = $app[UserService::USER_USER]->update($request->get('id'), $request);

        return new View($user, View::HTTP_NO_CONTENT);
    }

    /**
     * DELETE request route for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $user = $app[UserService::USER_USER]->remove($request->get('id'));

        return new View($user, View::HTTP_NO_CONTENT);
    }

    /**
     * Create an user
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function create(Application $app, Request $request)
    {
        $app['profile'] = $app[UserService::USER_USER]->create($request);

        $app['dispatcher']->dispatch(CreateEvent::NAME);

        return new View($app['profile'], View::HTTP_CREATED);
    }
}
