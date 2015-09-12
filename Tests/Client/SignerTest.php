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

        $this->assertEquals('9565a454cb8973824499f4117dfa4bd1', $this->signer->sign($content));
    }

    public function testSignSimple()
    {
        $content = 'secret content';

        $this->assertEquals('3c56c498', $this->signer->signSimple($content));
    }
}
