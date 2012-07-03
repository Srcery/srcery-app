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
          return 'test';
        });
        //->method('POST|GET');

        $controllers->match('/{id}', function (Application $app, $id) {
          if (strtolower($app['request']->getMethod()) == 'options') {
            $response = new Response('', 200);
            $response->prepare($app['request']);
            return $response;
          }
          if (!empty($id)) {
            $params['id'] = $id;
          }
          $app['srcery.params'] = $params;
          $app['srcery.resource_type'] = 'img';
          $resource = $app['srcery.activeresource'];
          $response = $resource->handleRequest($app['request']);
          $response_content = $response->getContent();
          if (!empty($response_content)) {
            $response->headers->set('Content-Type', 'application/json');
          }
          return $response;
        })
        ->method('GET|OPTIONS|PUT|POST|DELETE');

        return $controllers;
    }
}