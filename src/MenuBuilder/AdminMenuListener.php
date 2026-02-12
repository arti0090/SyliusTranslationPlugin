<?php

declare(strict_types=1);

namespace Locastic\SyliusTranslationPlugin\MenuBuilder;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Webmozart\Assert\Assert;

final class AdminMenuListener
{
    public function addTranslationMenuItem(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $configurationMenu = $menu->getChild('configuration');
        Assert::isInstanceOf($configurationMenu, ItemInterface::class);

        $configurationMenu
            ->addChild('translations', ['route' => 'locastic_sylius_translations_admin_index'])
            ->setLabel('locastic_sylius_translation.ui.menu.translations')
            ->setLabelAttribute('icon', 'language')
        ;
    }
}
