<?php

namespace Srcery\UrlService;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourceControllerProvider implements ControllerProviderInterface
{
    protected function resource_type() {
      return '';
    }

    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

        // Don't allow the root path.
        $controllers->match('/', function (Application $app, Request $request) {
          return new Response(404, 'Unknown resource.');
        });

        // Get the type.
        $app['srcery.resource_type'] = $this->resource_type();

        // The controller must have an ID.
        $controllers->match('/{id}', function (Application $app, $id) {

          // Always return 200 on an options request.
          if (strtolower($app['request']->getMethod()) == 'options') {
            $response = new Response('', 200);
            $response->prepare($app['request']);
            return $response;
          }

          if (!empty($id)) {
            $params['id'] = $id;
          }
          $app['srcery.params'] = $params;
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