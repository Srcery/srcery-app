<?php

namespace Srcery\UrlService;

namespace Srcery\UrlService;

use Srcery\Server\Derivative;
use Srcery\UrlService\ResourceControllerProvider;

class DerivativeControllerProvider extends ResourceControllerProvider
{
   function __construct()
   {
     $this->resource_path = 'der';
   }
}