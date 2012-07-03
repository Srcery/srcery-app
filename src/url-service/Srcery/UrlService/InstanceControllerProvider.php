<?php

namespace Srcery\UrlService;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Srcery\Server\Instance;

class InstanceControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Application $app, Request $request) {
           // return $app->redirect('/hello');
           return 'instance';
        });
        //->method('POST|GET');

        $controllers->match('/{id}', function (Application $app, $id, Request $request) {
          // return $app->redirect('/hello');
          return 'instance';
        });
        //->method('POST|GET');

        return $controllers;
    }
}