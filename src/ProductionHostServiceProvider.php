<?php

declare(strict_types = 1);

namespace Jnjxp\ProductionHost;

use Interop\Container\ServiceProviderInterface;

class ProductionHostServiceProvider implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [ProductionHost::class => ProductionHostFactory::class];
    }

    public function getExtensions()
    {
        return [];
    }
}
