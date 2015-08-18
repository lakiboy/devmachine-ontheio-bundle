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
            $container
                ->getDefinition('devmachine_ontheio.client.image.buzz')
                ->replaceArgument(0, $config['image'])
            ;
            $container->setAlias('devmachine_ontheio.client.image', 'devmachine_ontheio.client.image.buzz');
        }
    }
}
