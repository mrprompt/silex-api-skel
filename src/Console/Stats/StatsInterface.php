<?php
/**
 * This file is part of Skel system
 *
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */
namespace Skel\Console\Stats;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Stats Console Interface
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
interface StatsInterface
{
    /**
     * Show helper
     *
     * @return void
     */
    public function configure();

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    public function execute(InputInterface $input, OutputInterface $output);
}
