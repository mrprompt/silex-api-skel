<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license GPL
 */
namespace Skel\Tests;

use PHPUnit_Framework_BaseTestListener;
use PHPUnit_Framework_TestSuite;

/**
 * Application Test Suite Bootstrap
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class ApplicationTestListener extends PHPUnit_Framework_BaseTestListener
{
    /**
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        $this->suite = $suite;

        if (
            (strpos($suite->getName(), "Controller") !== false) ||
            (strpos($suite->getName(), "Service") !== false) ||
            (strpos($suite->getName(), "Repository") !== false)
        ) {
            require_once 'phpunit-bootstrap.php';
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        require_once 'phpunit-shutdown.php';
    }
}