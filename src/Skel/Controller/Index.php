<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Controller;

use Skel\Application;
use Skel\View\Json as View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Index Controller
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Index
{
    /**
     * GET Request for /
     *
     * @param  Application $app
     * @return Application
     */
    public function get(Application $app)
    {
        return new View([], View::HTTP_OK);
    }
}
