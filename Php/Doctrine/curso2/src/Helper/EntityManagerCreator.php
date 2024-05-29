<?php

namespace Alura\Doctrine\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class EntityManagerCreator
{
    public static function createEntityManager(): EntityManager
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__ . "/.."),
            isDevMode: true,
        );
        $consoleOutput = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
        $consoleLogger = new ConsoleLogger($consoleOutput);
        $logMiddleware = new Middleware($consoleLogger);
        $config->setMiddlewares([$logMiddleware]);

        $cacheDirectory = __DIR__ . '/../../var/cache';
        $config->setMetadataCache(
            new PhpFilesAdapter(
                namespace: 'metadata_cache',
                directory: $cacheDirectory
            )
        );

        $config->setQueryCache(
            new PhpFilesAdapter(
                namespace: 'query_cache',
                directory: $cacheDirectory
            )
        );

        $config->setResultCache(
            new PhpFilesAdapter(
                namespace: 'result_cache',
                directory: $cacheDirectory
            )
            );
        
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'davi_students',
            'user' => 'root',
            'password' => '1234'
        ], $config);

        $entityManager = new EntityManager($connection, $config);

        return $entityManager;
    }
}