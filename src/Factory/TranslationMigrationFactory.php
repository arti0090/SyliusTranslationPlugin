<?php

declare(strict_types=1);

namespace Locastic\SyliusTranslationPlugin\Factory;

use Locastic\SymfonyTranslationBundle\Factory\TranslationMigrationFactoryInterface;
use Locastic\SymfonyTranslationBundle\Model\TranslationMigrationInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final readonly class TranslationMigrationFactory implements FactoryInterface, TranslationMigrationFactoryInterface
{
    public function __construct(private string $className)
    {
    }

    public function createNew(): TranslationMigrationInterface
    {
        /** @var TranslationMigrationInterface $migration */
        $migration = new $this->className();

        return $migration;
    }
}
