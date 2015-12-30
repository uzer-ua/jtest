<?php
namespace Jtest;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

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
		$app->before(function (Request $request) {
			if (strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
				$data = json_decode($request->getContent(), true);
				$request->request->replace(is_array($data) ? $data : array());
			}
		});
		$controllers = $app['controllers_factory'];

		$controllers->get('contact', function (Application $app) {
			return $app->json($this->getData());
		});
		$controllers->get('contact/{id}', function ($id) use ($app) {
			$data = $this->getContact($id);
			if ($data) {
				return $app->json($data, 200);
			}
			else {
				return $app->json(null, 404);
			}
		});
		$controllers->post('contact', function (Request $request) use ($app) {
			$record = array(
				'name' => $request->request->get('name'),
				'tel'  => $request->request->get('tel')
			);
			$record['id'] = $this->save($record);
			if ($record['id']) {
				return $app->json($record, 201);
			}
			else {
				return $app->json(null, 400);
			}
		});
		$controllers->put('contact/{id}', function ($id, Request $request) use ($app) {
			$record = array(
				'id' => $id,
				'name' => $request->request->get('name'),
				'tel'  => $request->request->get('tel')
			);
			$this->save($record);
			return $app->json(null, 204);
		});
		$controllers->delete('contact/{id}', function ($id) use ($app) {
			if ($this->delete($id)) {
				return $app->json(null, 204);
			}
			else {
				return $app->json(null, 404);
			}
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
	private function getData () {
		$sql = "SELECT * FROM contacts";
		return $this->app['db']->fetchAll($sql);
	}

	private function getContact ($id) {
		$sql = "SELECT * FROM contacts WHERE id = ?";
		$args = array($id);
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
