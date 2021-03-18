<?php

declare(strict_types=1);

namespace CoralMedia\Bundle\ShippingBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class CoralMediaShippingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'coral_media.shipping.ups.api_key',
            $config['UPS']['credentials']['api_key']
        );
        $container->setParameter(
            'coral_media.shipping.ups.username',
            $config['UPS']['credentials']['username']
        );
        $container->setParameter(
            'coral_media.shipping.ups.password',
            $config['UPS']['credentials']['password']
        );
        $container->setParameter(
            'coral_media.shipping.ups.testing',
            $config['UPS']['testing']
        );

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        try {
            $loader->load('services.yaml');
        } catch (Exception $e) {
        }
    }
}
