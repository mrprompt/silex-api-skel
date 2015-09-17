<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Controller\Home;

use Skel\Bootstrap as Application;
use Skel\Response as View;

/**
 * Index Controller
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Index implements IndexInterface
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
