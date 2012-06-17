<?php 
// web/index.php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

// Debug helper provided by Silex
$app['debug'] = TRUE;

// Extension registers.
$app->register(new Silex\Provider\SessionServiceProvider());

// Routing.
$app->get('/', function() use($app) {
   $app['session']->start();
   return 'welcome to srcery';
});

$app->run();
