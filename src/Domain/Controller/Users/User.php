<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Domain\Controller\Users;

use Skel\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Controller Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface User
{
    /**
     * GET Request for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app);

    /**
     * GET request for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request);

    /**
     * PUT request route for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function update(Application $app, Request $request);

    /**
     * DELETE request route for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);

    /**
     * Create an user
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function create(Application $app, Request $request);
}
