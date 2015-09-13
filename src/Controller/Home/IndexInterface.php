<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Controller\Home;

use Skel\Bootstrap as Application;

/**
 * Index Controller Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface IndexInterface
{
    /**
     * @param  Application $app
     * @return Application
     */
    public function get(Application $app);
}
