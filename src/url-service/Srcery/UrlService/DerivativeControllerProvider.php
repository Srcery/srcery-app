<?php

namespace Srcery\UrlService;

namespace Srcery\UrlService;

use Srcery\Server\Derivative;
use Srcery\UrlService\ResourceControllerProvider;

class DerivativeControllerProvider extends ResourceControllerProvider
{
    protected function resource_type()
    {
        return 'der';
    }
}