<?php

namespace Devmachine\Bundle\OntheioBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DevmachineOntheioExtension extends ConfigurableExtension
{
    protected function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (!empty($config['image'])) {
            $container->setParameter('devmachine_ontheio.client.image.base_url', $config['image']['base_url']);

            $container
                ->getDefinition('devmachine_ontheio.client.image.signer')
                ->setArguments([$config['image']['key'], $config['image']['secret']])
                ->setAbstract(false)
            ;
        }
    }
}
