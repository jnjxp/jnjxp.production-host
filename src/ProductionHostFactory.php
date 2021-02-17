<?php

declare(strict_types=1);

namespace Jnjxp\ProductionHost;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;

class ProductionHostFactory
{
    const HOST = 'PRODUCTION_HOST';

    public function __invoke(ContainerInterface $container) : MiddlewareInterface
    {
        return new ProductionHost(
            $container->get(ResponseFactoryInterface::class),
            $container->has(self::HOST) ? $container->get(self::HOST) : null
        );
    }

    public static function read(string $file = self::HOST) : ?string
    {
        return file_exists($file) ? trim(file_get_contents($file)) : null;
    }
}
