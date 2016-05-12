<?php
use Knp\Provider\ConsoleServiceProvider;
use User\Console\User;

set_time_limit(0);

$app = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app->register(new ConsoleServiceProvider(), array(
    'console.name'              => 'Cconsole',
    'console.version'           => '0.0.0',
    'console.project_directory' => __DIR__ . DIRECTORY_SEPARATOR
));

$app = $app['console'];
$app->add(new User());

return $app;
