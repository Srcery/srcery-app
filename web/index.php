<?php 
// web/index.php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// Debug helper provided by Silex
$app['debug'] = TRUE;

// Extension registers.
// SessionServiceProvider
//$app->register(new Silex\Provider\SessionServiceProvider());
// Mongo

$app->register(new SilexExtension\MongoDbExtension(), array(
  'mongodb.class_path' => __DIR__ . '/../vendor/mongodb/lib',
  'mongodb.connection' => array(
    'server' => 'mongodb://srcery_db_user:srcery_db_pass9889@localhost/srcery_mongodb',
    'options' => array(),
    'eventmanager' => function($eventmanager) {},
  ),
));

// Routing.
$app->get('/', function() use($app) {
   //$app['session']->start();
   return 'welcome to srcery';
});

$app->get('/mongotest', function() use ($app) {
  $coll = $app['mongodb']->selectDatabase('srcery_mongodb')->selectCollection('test_collection');
  $result = $coll->find()->toArray();
  $response = new Response();
  $response->headers->set('Content-type', 'application/json');
  $response->setContent(json_encode($result));
 return $response;
});

$app->run();