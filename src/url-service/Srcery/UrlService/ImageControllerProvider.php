<?php

namespace Srcery\UrlService;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Srcery\Server\Image;

class ImageControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        $controllers->match('/', function (Application $app, Request $request) {
          //$resource = new Image($app);
          //$resource->handleRequest($request);
          //$resource->save();
          return 'test';
        });
        //->method('POST|GET');

        $controllers->match('/{id}', function (Application $app, $id) {
          if (strtolower($app['request']->getMethod()) == 'options') {
            //$response = new Response('Content', 200, array('content-type' => 'text/html'));
            $response = new Response('', 200, array(header('HTTP/1.1 200 OK', true, 200)));
            $response->prepare($app['request']);
            return $response;
          }
          if (!empty($id)) {
            $params['id'] = $id;
          }
          $app['srcery.params'] = $params;
          $app['srcery.resource_type'] = 'img';
          $resource = $app['srcery.activeresource'];
          $resource->handleRequest($app['request']);
          /*$args = $_POST;
          $params = $args;

          $resource = new Image($app, $params);
          //$resource->handleRequest($request);
          $resource->save();
          return $request->getMethod();*/
          return $app['request']->getMethod();
        });
        //->method('GET|OPTIONS');

        return $controllers;
    }
}