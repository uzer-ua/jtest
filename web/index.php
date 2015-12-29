<?php
$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Jtest\\', array(__DIR__.'/../app/controllers'));

use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();

$app = new Silex\Application();
$app['debug'] = true;

require __DIR__.'/../app/registers.php';

$app->mount('/contact', new Jtest\ContactController());

$app->run();
?>