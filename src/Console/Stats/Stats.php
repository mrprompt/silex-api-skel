<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license   proprietary
 */
namespace Skel\Console\Stats;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Stats Service
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Stats extends Command implements StatsInterface
{
    /**
     * Show helper
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('stats:count')->setDescription('Hello World!');
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return string
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $consoleApp \Knp\Console\Application */
        $consoleApp = $this->getApplication();

        /* @var $app \Skel\Bootstrap */
        $app        = $consoleApp->getSilexApplication();

        $result     = [1];

        return $output->writeln(sprintf("Updated resources: %s", count($result)));
    }
}
