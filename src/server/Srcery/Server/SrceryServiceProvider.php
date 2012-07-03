<?php
namespace Srcery\Server;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Srcery\Server\MongoResource;
use Srcery\Server\Resource;
use Srcery\Server\Image;
use Srcery\Server\Instance;
use Srcery\Server\Derivative;
use Srcery\Server\File;

class SrceryServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
      //$a = $b;
      $defaults = array(
        'folder' => '',
        'place_holder' => '',
        'mongodb_name' => '',
      );

      $app['srcery.activeresource'] = $app->share(function () use ($app, $defaults) {
        $db_name = $app['srcery.mongodb_name'];
        $db = $app['mongodb']->selectDatabase($db_name);
        $collection_name = 'resources';
        $mongoResource = new MongoResource($db, $collection_name, $app['srcery.params']);

        $options = array(
          'folder' => $app['srcery.folder'],
          'place_holder' => $app['srcery.place_holder'],
        );
        switch ($app['srcery.resource_type']) {
          // @todo possibly pass mongoresource or app inside of closure, and let the class instantiate its own.
          case 'img':
            $resource = new Image($mongoResource, $app['srcery.params'], $options);
            break;
        }
        return $resource;
      });
    }

    public function boot(Application $app)
    {
    }
}