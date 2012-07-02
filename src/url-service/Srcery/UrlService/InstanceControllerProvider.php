<?php

namespace Srcery\UrlService;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class InstanceControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {
           // return $app->redirect('/hello');
           return 'instance';
        });

        return $controllers;
    }
}