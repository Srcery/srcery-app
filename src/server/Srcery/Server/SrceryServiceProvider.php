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
        'folder' => array(),
        'place_holder' => array(),
        'mongodb_name' => 'srcery_mongodb',
        'resource_collection_name' => '',
      );

      $app['srcery.activeresource'] = $app->share(function () use ($app, $defaults) {
        $db_name = $app['srcery.mongodb_name'] ? $app['srcery.mongodb_name'] : $defaults['mongodb_name'];
        $db = $app['mongodb']->selectDatabase($db_name);
        $collection_name = $app['srcery.resource_collection_name'] ? $app['srcery.resource_collection_name'] : $defaults['resource_collection_name'];
        $mongoResource = new MongoResource($db, $collection_name, $app['srcery.params']);

        $options = array(
          'folder' => $app['srcery.folder'][$app['srcery.resource_type']],
          'place_holder' => $app['srcery.place_holder'][$app['srcery.resource_type']],
        );
        switch ($app['srcery.resource_type']) {
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