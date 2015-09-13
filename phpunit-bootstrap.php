<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license proprietary
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;

$app = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

if (defined('NO_FIXTURES') || getenv('NO_FIXTURES')) {
    $app['logger']->addDebug('No fixtures loaded...');

    return $app;
}

$app['logger']->addDebug('Loading metadata...');

$metadata   = $app['orm.em']->getMetadataFactory()->getAllMetadata();

$app['logger']->addDebug('Creating schema...');

$tool       = new SchemaTool($app['orm.em']);
$tool->dropSchema($metadata);
$tool->createSchema($metadata);

$app['logger']->addDebug('Loading fixtures...');

$loader   = new Loader();
$loader->loadFromDirectory('tests/Fixtures');

$app['logger']->addDebug('Executing fixtures...');

$executor = new ORMExecutor($app['orm.em'], new ORMPurger());
$executor->execute($loader->getFixtures());

file_put_contents('tmp/phpunit-fixtures.tmp', 'true');

$app['logger']->addDebug('Fixtures loaded...');

return $app;
