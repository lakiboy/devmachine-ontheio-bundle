<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\DependencyInjection;

use Buzz\Browser;
use Devmachine\Bundle\OntheioBundle\DependencyInjection\DevmachineOntheioExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DevmachineOntheioExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var DevmachineOntheioExtension */
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    public function setUp()
    {
        $this->extension = new DevmachineOntheioExtension();
        $this->container = new ContainerBuilder();

        $this->container->set('buzz', new Browser());
    }

    public function testNoServicesRegisteredByDefault()
    {
        $this->extension->load([[]], $this->container);

        $this->container->compile();
        $this->assertFalse($this->container->has('devmachine_ontheio.client.image'));
    }

    public function testImageClientServiceIsRegistered()
    {
        $config = [
            'image' => [
                'key' => 'abc',
                'secret' => 'xyz',
            ],
        ];

        $this->extension->load([$config], $this->container);

        $this->container->compile();
        // $this->assertTrue($this->container->has('devmachine_ontheio.client.image'));

        $client = $this->container->get('devmachine_ontheio.client.image');

        $this->assertInstanceOf('Devmachine\Bundle\OntheioBundle\Client\Image\Uploader', $client);
        $this->assertInstanceOf('Devmachine\Bundle\OntheioBundle\Client\Image\Manipulator', $client);
    }
}
