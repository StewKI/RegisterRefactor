<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Container;
use App\Contracts\AuthServiceInterface;
use App\Contracts\DataLoaderInterface;
use App\Contracts\Providers\IpProviderInterface;
use App\Contracts\Providers\MailAddressProviderInterface;
use App\Contracts\Providers\MailContentProviderInterface;
use App\Contracts\Query\QueryBuilderFactoryInterface;
use App\Contracts\Repositories\MailRepositoryInterface;
use App\Contracts\Repositories\UserLogRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\FraudDetectionServiceInterface;
use App\Contracts\Services\HashingServiceInterface;
use App\Contracts\Services\Mail\MailSenderServiceInterface;
use App\Contracts\Services\Mail\MailTemplateServiceInterface;
use App\Contracts\Services\Mail\QueueMailServiceInterface;
use App\Contracts\Services\Mail\SendQueuedMailsServiceInterface;
use App\Contracts\Services\RegisterServiceInterface;
use App\Contracts\Services\UserCreatorServiceInterface;
use App\Contracts\SessionInterface;
use App\Contracts\Validation\Validators\UserRegistrationValidatorInterface;
use App\DB;
use App\Providers\IpProvider;
use App\Providers\MailAddressProvider;
use App\Providers\MailContentProvider;
use App\Query\Mysqli\MysqliQueryBuilderFactory;
use App\Repositories\MailRepository;
use App\Repositories\UserLogRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\Mail\MailTemplateService;
use App\Services\Mail\PhpMailerMailSenderService;
use App\Services\Mail\QueueMailService;
use App\Services\Mail\SendQueuedMailsService;
use App\Services\NativeHashingService;
use App\Services\RegisterService;
use App\Services\ThirdParty\MaxMindFraudDetectionServiceMock;
use App\Services\UserCreatorService;
use App\Session;
use App\Utils\JsonDataLoader;
use App\Validation\Validators\UserRegistrationValidator;
use Psr\Container\ContainerInterface;

$singletons = [
    DB::class => function (ContainerInterface $container) {
        $config = $container->get(Config::class);

        return new DB($config->db);
    },
];

$bindings = [
    mysqli::class                          => function (ContainerInterface $container) {
        $db = $container->get(DB::class);
        return $db->getMysqli();
    },
    QueryBuilderFactoryInterface::class    => function (ContainerInterface $container) {
        return $container->get(MysqliQueryBuilderFactory::class);
    },
    SessionInterface::class                => Session::class,
    AuthServiceInterface::class            => AuthService::class,
    UserRepositoryInterface::class         => UserRepository::class,
    UserLogRepositoryInterface::class      => UserLogRepository::class,
    RegisterServiceInterface::class        => RegisterService::class,
    MailSenderServiceInterface::class      => function (ContainerInterface $container) {
        $config = $container->get(Config::class);
        return new PhpMailerMailSenderService($config->mail);
    },
    QueueMailServiceInterface::class       => QueueMailService::class,
    SendQueuedMailsServiceInterface::class => SendQueuedMailsService::class,
    MailRepositoryInterface::class         => MailRepository::class,
    DataLoaderInterface::class => function(ContainerInterface $container) {
        return new JsonDataLoader(RESOURCES_DIR . "/data");
    },
    MailAddressProviderInterface::class => MailAddressProvider::class,
    MailContentProviderInterface::class => MailContentProvider::class,
    MailTemplateServiceInterface::class => MailTemplateService::class,
    UserRegistrationValidatorInterface::class => UserRegistrationValidator::class,
    FraudDetectionServiceInterface::class => MaxMindFraudDetectionServiceMock::class,
    IpProviderInterface::class => IpProvider::class,
    HashingServiceInterface::class => NativeHashingService::class,
    UserCreatorServiceInterface::class => UserCreatorService::class,
];

return function (Container $container): void
{
    $container->set(ContainerInterface::class, fn(ContainerInterface $container) => $container);

    global $singletons;
    $container->singletonMultiple($singletons);

    global $bindings;
    $container->setMultiple($bindings);
};