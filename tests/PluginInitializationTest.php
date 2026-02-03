<?php

declare(strict_types=1);

use Locastic\SyliusTranslationPlugin\Provider\ThemesProvider;
use Locastic\SyliusTranslationPlugin\Provider\TranslationFilePathProvider;
use Locastic\SymfonyTranslationBundle\Provider\ThemesProviderInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\TwigFunction;
use Locastic\SyliusTranslationPlugin\MenuBuilder\AdminMenuListener;

class PluginInitializationTest extends KernelTestCase
{
    public function testItCanInstantiateMainTranslationServices(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $serviceId = ThemesProvider::class;
        $this->assertTrue($container->has($serviceId));

        $service = $container->get($serviceId);
        $this->assertInstanceOf(ThemesProviderInterface::class, $service);
    }

    public function testItDecoratesTranslationFilePathProvider(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $service = $container->get(TranslationFilePathProvider::class);

        $this->assertInstanceOf(TranslationFilePathProvider::class, $service);
    }

    public function testItRegistersTwigFunction(): void
    {
        self::bootKernel();
        $twig = self::getContainer()->get('twig');

        $function = $twig->getFunction('locastic_sylius_translation_get_themes');

        $this->assertNotFalse($function, 'Twig function is not registered!');
        $this->assertInstanceOf(TwigFunction::class, $function);
    }

    public function testItIsSubscribedToAdminMenuEvent(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $eventDispatcher = $container->get('event_dispatcher');
        $listeners = $eventDispatcher->getListeners('sylius.menu.admin.main');

        $isRegistered = false;
        foreach ($listeners as $listener) {
            if (is_array($listener) && $listener[0] instanceof AdminMenuListener) {
                $isRegistered = true;
                break;
            }
        }

        $this->assertTrue($isRegistered, 'AdminMenuListener does not listen on sylius.menu.admin.main');
    }
}
