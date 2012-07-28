<?php

namespace Srcery\UrlService;

namespace Srcery\UrlService;

use Srcery\Server\Instance;
use Srcery\UrlService\ResourceControllerProvider;

class InstanceControllerProvider extends ResourceControllerProvider
{
   function __construct()
   {
     $this->resource_path = 'inst';
   }
}