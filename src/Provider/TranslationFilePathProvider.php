<?php

declare(strict_types=1);

namespace Locastic\SyliusTranslationPlugin\Provider;

use Locastic\SymfonyTranslationBundle\Model\TranslationValueInterface;
use Locastic\SymfonyTranslationBundle\Provider\DefaultTranslationDirectoryProviderInterface;
use Locastic\SymfonyTranslationBundle\Provider\ThemesProviderInterface;
use Locastic\SymfonyTranslationBundle\Provider\TranslationFilePathProviderInterface;
use Webmozart\Assert\Assert;

final readonly class TranslationFilePathProvider implements TranslationFilePathProviderInterface
{
    public function __construct(
        private TranslationFilePathProviderInterface $decoratedTranslationFilePathProvider,
        private ThemesProviderInterface $themesProvider,
        private DefaultTranslationDirectoryProviderInterface $defaultTranslationDirectoryProvider,
    ) {
    }

    public function getFilePath(TranslationValueInterface $translationValue): string
    {
        $themeName = $translationValue->getTheme();
        Assert::notNull($themeName);

        $theme = $this->themesProvider->findOneByName($themeName);
        if (null === $theme || ThemesProviderInterface::NAME_DEFAULT === $theme->getName()) {
            return $this->defaultTranslationDirectoryProvider->getDefaultDirectory();
        }

        return $theme->getPath() . '/translations/';
    }

    public function getDefaultDirectory(): string
    {
        /* @phpstan-ignore-next-line */
        return $this->decoratedTranslationFilePathProvider->getDefaultDirectory();
    }
}
