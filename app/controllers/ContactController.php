<?php
namespace Jtest;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\TwigServiceProvider;

class ContactController implements ControllerProviderInterface {
	/**
	 * @var Application
	 */
	private $app;

	public function connect(Application $app) {
		$this->app = $app;
		$app->get('/', function () {
			return $this->index();
		});
		$controllers = $app['controllers_factory'];

		$controllers->get('/', function (Application $app) {
			return $this->index();
		});

		return $controllers;
	}

	public function index () {
		$this->app->register(new TwigServiceProvider(), array(
			'twig.path' => __DIR__.'/../views',
		));
		return $this->app['twig']->render('index.twig');
	}

	//TODO: move to model
	private function getData ($id = null) {
		$sql = "SELECT * FROM contacts";
		$args = array();
		if ($id) {
			$sql .= " WHERE id = ?";
			$args[] = $id;
		}
		return $this->app['db']->fetchAssoc($sql, $args);
	}

	//TODO: overload for plain args
	private function save ($data) {
		if (@$data['id']) {
			$id = $data['id'];
			unset($data['id']);
			return $this->app['db']->update('contacts', $data, array('id' => $id));
		}
		else {
			return $this->app['db']->insert('contacts', $data);
		}
	}

	private function delete ($id) {
		return $this->app['db']->delete('contacts', array('id' => $id));
	}
}

?>
