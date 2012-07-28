<?php

namespace Srcery\UrlService;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourceControllerProvider implements ControllerProviderInterface
{
    public $resource_path = '';
    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        // Don't allow the root path.
        $controllers->match('/', function (Application $app, Request $request) {
          return new Response(404, 'Unknown resource.');
        });

        // Get the path.
        $path = $this->resource_path;

        // The controller must have an ID.
        $controllers->match('/{id}', function (Application $app, $id) use ($path) {
          $app['srcery.resource_path'] = $path;
          $app['srcery.params'] = array('id' => $id);
          $resource = $app['srcery.resource'];
          $response = $resource->handleRequest($app['request']);
          $response_content = $response->getContent();
          if (!empty($response_content)) {
            $response->headers->set('Content-Type', 'application/json');
          }
          return $response;
        })
        ->method('GET|PUT|POST|DELETE');

        return $controllers;
    }
}