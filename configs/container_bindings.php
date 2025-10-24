<?php

declare(strict_types=1);

use App\Container;
use Psr\Container\ContainerInterface;

return function (Container $container): void
{
    $container->set(ContainerInterface::class, fn(ContainerInterface $container) => $container);
};