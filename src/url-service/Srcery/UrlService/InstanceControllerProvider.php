<?php

namespace Srcery\UrlService;

namespace Srcery\UrlService;

use Srcery\Server\Instance;
use Srcery\UrlService\ResourceControllerProvider;

class InstanceControllerProvider extends ResourceControllerProvider
{
    protected function resource_type()
    {
        return 'inst';
    }
}