<?php
declare(strict_types = 1);

namespace User\Console;

use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * User Console
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class User extends Command
{
    /**
     * Show helper
     *
     * @return void
     */
    public function configure()
    {
        $this->setName('users:list')->setDescription('List all users');
    }

    /**
     * Execute command
     *
     * @param  InputInterface $input
     * @param  OutputInterface $output
     * @return string
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $consoleApp \Knp\Console\Application */
        $consoleApp = $this->getApplication();

        /* @var $app \Bootstrap */
        $app = $consoleApp->getSilexApplication();

        $result = $app['user.service']->listAll();

        /* @var $user \User\Entity\UserInterface */
        array_Walk($result, function($user) use($output) {
            $output->writeln($user->getName() . ' - ' . $user->getEmail());
        });

        return true;
    }
}
