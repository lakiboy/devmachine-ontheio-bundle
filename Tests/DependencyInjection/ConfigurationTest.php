<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\DependencyInjection;

use Devmachine\Bundle\OntheioBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $config = $this->processConfig([]);

        $this->assertEquals([], $config);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "key" at path "devmachine_ontheio.image" must be configured.
     */
    public function testImageConfigRequiresKey()
    {
        $this->processConfig(['image' => []]);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The child node "secret" at path "devmachine_ontheio.image" must be configured.
     */
    public function testImageConfigRequiredSecret()
    {
        $this->processConfig(['image' => ['key' => 'key']]);
    }

    public function testImageConfig()
    {
        $config = $this->processConfig(['image' => ['key' => 'abc', 'secret' => 'xyz']]);

        $this->assertEquals([
            'image' => [
                'key' => 'abc',
                'secret' => 'xyz',
                'base_url' => 'https://i.onthe.io',
            ],
        ], $config);
    }

    protected function processConfig($config)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), [$config]);
    }
}
