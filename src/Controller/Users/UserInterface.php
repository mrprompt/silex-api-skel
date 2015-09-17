<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Controller\Users;

use Skel\Bootstrap as Application;

/**
 * User Controller Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface UserInterface
{
    /**
     * @param  Application $app
     * @return View
     */
    public function get(Application $app);

    /**
     * @param  Application $app
     * @return View
     */
    public function view(Application $app);

    /**
     * @param  Application $app
     * @return View
     */
    public function update(Application $app);

    /**
     * @param  Application $app
     * @return View
     */
    public function delete(Application $app);

    /**
     * @param  Application $app
     * @return View
     */
    public function create(Application $app);
}
