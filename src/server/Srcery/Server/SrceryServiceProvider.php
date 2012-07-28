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

      $defaults = array(
        'folder' => '',
        'place_holder' => '',
        'mongodb_name' => 'srcery_mongodb',
        'resource_collection_name' => '',
      );

      $app['srcery.resource'] = $app->share(function () use ($app, $defaults) {
        $db_name = !empty($app['srcery.mongodb_name']) ? $app['srcery.mongodb_name'] : $defaults['mongodb_name'];
        $db = $app['mongodb']->selectDatabase($db_name);
        $collection_name = !empty($app['srcery.resource_collection_name']) ? $app['srcery.resource_collection_name'] : $defaults['resource_collection_name'];
        $mongoResource = new MongoResource($db, $collection_name, $app['srcery.params']);

        $options = array(
          'folder' => !empty($app['srcery.folder']) ? $app['srcery.folder'] : $defaults['folder'],
          'place_holder' => !empty($app['srcery.place_holder']) ? $app['srcery.place_holder'] : $defaults['place_holder'],
        );

        switch ($app['srcery.resource_path']) {
          case 'img':
            $resource = new Image($mongoResource, $app['srcery.params'], $options);
            break;
          case 'inst':
            $resource = new Instance($mongoResource, $app['srcery.params'], $options);
            break;
          case 'der':
            $resource = new Derivative($mongoResource, $app['srcery.params'], $options);
            break;
        }

        return $resource;
      });
    }

    public function boot(Application $app)
    {
    }
}