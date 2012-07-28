<?php

namespace Srcery\UrlService;

use Srcery\Server\Image;
use Srcery\UrlService\ResourceControllerProvider;

class ImageControllerProvider extends ResourceControllerProvider
{
   function __construct()
   {
     $this->resource_path = 'img';
   }
}