<?php
declare(strict_types = 1);

namespace User\Controller;

use Silex\Application;
use Common\Response as View;

/**
 * User Controller
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
final class User
{
    /**
     * Route to /user/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app): View
    {
        /* @var $users array */
        $users    = $app['user.service']->listAll();

        return new View($users, View::HTTP_OK);
    }

    /**
     * Retrieves information from user
     *
     * @param  Application $app
     * @return View
     */
    public function view(Application $app): View
    {
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $request = $app['request'];

        /* @var $id int */
        $id      = (int) $request->get('id');

        /* @var $user \User\Entity\UserInterface */
        $user    = $app['user.service']->findByUserId($id);

        return new View($user, View::HTTP_OK);
    }
}
