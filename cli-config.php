<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license proprietary
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use UseAllFive\Command\LoadDataFixturesDoctrineCommand;
use Symfony\Component\Console\Helper\DialogHelper;

$app = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$helperSet = new HelperSet(array(
    'db' => new ConnectionHelper($app['orm.em']->getConnection()),
    'em' => new EntityManagerHelper($app['orm.em']),
    'dialog' => new DialogHelper(),
));

$commands = array(
    new LoadDataFixturesDoctrineCommand(),
    new DiffCommand(),
    new ExecuteCommand(),
    new GenerateCommand(),
    new MigrateCommand(),
    new StatusCommand(),
    new VersionCommand()
);

return $helperSet;
