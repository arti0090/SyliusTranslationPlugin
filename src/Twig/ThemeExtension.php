<?php

declare(strict_types=1);

namespace Locastic\SyliusTranslationPlugin\Twig;

use Locastic\SymfonyTranslationBundle\Provider\ThemesProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ThemeExtension extends AbstractExtension
{
    public function __construct(private readonly ThemesProviderInterface $themeProvider)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('locastic_sylius_translation_get_themes', $this->themeProvider->getAll(...)),
        ];
    }
}
