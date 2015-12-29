<?php
require 'config.php';
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
	'db.options' => $db_config
));
?>