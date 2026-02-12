<?php

declare(strict_types=1);

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Sylius\Bundle\ResourceBundle\SyliusResourceBundle::class => ['all' => true],
    Locastic\SymfonyTranslationBundle\LocasticSymfonyTranslationBundle::class => ['all' => true],
    Locastic\SyliusTranslationPlugin\LocasticSyliusTranslationPlugin::class => ['all' => true],
];
