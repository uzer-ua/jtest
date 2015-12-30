<?php
$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Jtest\\', array(__DIR__.'/../app/controllers'));

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app = new Silex\Application();
$app['debug'] = true;

require __DIR__.'/../app/registers.php';

//I'd rather mount to /contact but I haven't succeed to make this strange trailing-slash routing work correctly with Angular $resource
$app->mount('/', new Jtest\ContactController());

$app->run();
?>
