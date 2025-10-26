<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Container;
use App\Contracts\Query\QueryBuilderFactoryInterface;
use App\Contracts\Repositories\MailRepositoryInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Mail\MailSenderServiceInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\Contracts\Services\Mail\SendQueuedMailsServiceInterface;
use App\Contracts\Services\RegisterServiceInterface;
use App\Query\Mysqli\MysqliQueryBuilderFactory;
use App\Repositories\MailRepository;
use App\Repositories\UserLogRepository;
use App\Repositories\UserRepository;
use App\Services\Mail\PhpMailerMailSenderService;
use App\Services\Mail\QueueMailService;
use App\Services\Mail\SendQueuedMailsService;
use App\Services\RegisterService;
use Psr\Container\ContainerInterface;

$bindings = [
    mysqli::class => fn () => App::getDb()->getMysqli(),
    QueryBuilderFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(MysqliQueryBuilderFactory::class);
    },
    UserRepositoryInterface::class => UserRepository::class,
    UserLogRepositoryInterface::class => UserLogRepository::class,
    RegisterServiceInterface::class => RegisterService::class,
    MailSenderServiceInterface::class => function (ContainerInterface $container) {
        $config = $container->get(Config::class);
        return new PhpMailerMailSenderService($config->mail);
    },
    QueueMailServiceInterface::class => QueueMailService::class,
    SendQueuedMailsServiceInterface::class => SendQueuedMailsService::class,
    MailRepositoryInterface::class => MailRepository::class,
];

return function (Container $container): void
{
    global $bindings;
    $container->set(ContainerInterface::class, fn(ContainerInterface $container) => $container);
    $container->setMultiple($bindings);
};