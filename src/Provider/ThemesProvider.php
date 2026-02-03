<?php

declare(strict_types=1);

namespace Locastic\SyliusTranslationPlugin\Provider;

use Locastic\SymfonyTranslationBundle\Factory\ThemeFactoryInterface as LocasticThemeFactoryInterface;
use Locastic\SymfonyTranslationBundle\Model\ThemeInterface;
use Locastic\SymfonyTranslationBundle\Provider\ThemesProviderInterface;
use Sylius\Bundle\ThemeBundle\Factory\ThemeFactoryInterface as SyliusThemeFactoryInterface;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;

final readonly class ThemesProvider implements ThemesProviderInterface
{
    public function __construct(
        private ThemeRepositoryInterface $themeRepository,
        private SyliusThemeFactoryInterface $syliusThemeFactory,
        private LocasticThemeFactoryInterface $locasticThemeFactory,
    ) {
    }

    public function getAll(): array
    {
        $mappedThemes = array_map(
            fn ($t) => $this->locasticThemeFactory->createNew($t->getName(), $t->getPath()),
            $this->themeRepository->findAll(),
        );

        return array_merge([self::NAME_DEFAULT => $this->getDefaultTheme()], $mappedThemes);
    }

    public function findOneByName(string $name): ?ThemeInterface
    {
        if (self::NAME_DEFAULT === $name) {
            return $this->getDefaultTheme();
        }

        $syliusTheme = $this->themeRepository->findOneByName($name);
        if (null === $syliusTheme) {
            return null;
        }

        return $this->locasticThemeFactory->createNew($syliusTheme->getName(), $syliusTheme->getPath());
    }

    public function getDefaultTheme(): ThemeInterface
    {
        $syliusTheme = $this->syliusThemeFactory->create(self::NAME_DEFAULT, '');

        return $this->locasticThemeFactory->createNew($syliusTheme->getName(), $syliusTheme->getPath());
    }
}
