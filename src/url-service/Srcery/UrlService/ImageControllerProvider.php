<?php

namespace Srcery\UrlService;

use Srcery\Server\Image;
use Srcery\UrlService\ResourceControllerProvider;

class ImageControllerProvider extends ResourceControllerProvider
{
    protected function resource_type()
    {
        return 'img';
    }
}