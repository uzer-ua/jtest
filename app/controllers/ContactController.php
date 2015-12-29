<?php
namespace Jtest;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\TwigServiceProvider;

class ContactController implements ControllerProviderInterface {
	public function connect(Application $app) {
		$app->get('/', function () use ($app) {
			return $this->index($app);
		});
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Application $app) {
			return $this->index($app);
		});

		return $controllers;
	}

	public function index (Application $app) {
		$app->register(new TwigServiceProvider(), array(
			'twig.path' => __DIR__.'/../views',
		));
		return $app['twig']->render('index.twig');
	}
}

?>
