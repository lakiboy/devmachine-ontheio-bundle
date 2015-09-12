<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\Client;

use Devmachine\Bundle\OntheioBundle\Client\Image\Signer;

class SignerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Signer */
    private $signer;

    public function setUp()
    {
        $this->signer = new Signer('key', 'secret');
    }

    public function testGetKey()
    {
        $this->assertEquals('key', $this->signer->getKey());
    }

    public function testSign()
    {
        $content = 'secret content';

        $this->assertEquals(md5(sprintf('key%ssecret', $content)), $this->signer->sign($content));
    }

    public function testSignSimple()
    {
        $content = 'secret content';

        $this->assertEquals(substr(md5(sprintf('%ssecret', $content)), 0, 8), $this->signer->signSimple($content));
    }
}
