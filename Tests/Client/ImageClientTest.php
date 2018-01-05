<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\Client;

use Buzz\Browser;
use Buzz\Listener\ListenerInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Devmachine\Bundle\OntheioBundle\Client\Image\ImageClient;
use Devmachine\Bundle\OntheioBundle\Client\Image\Signer;

class ImageClientTest extends \PHPUnit_Framework_TestCase implements ListenerInterface
{
    private $signer;
    private $buzz;

    /** @var RequestInterface */
    private $request;

    public function setUp()
    {
        $this->signer = new Signer('key', 'secret');
        $this->buzz = new Browser($this->makeMock('Buzz\Client\ClientInterface'));
        $this->buzz->addListener($this);
    }

    public function preSend(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function postSend(RequestInterface $request, MessageInterface $response)
    {
        $response->setContent(json_encode([
            'key' => 'abc',
            'size' => '200x150',
            'full_size' => 'http://original.url',
        ]));
    }

    public function testUploadByUrl()
    {
        $client = new ImageClient($this->buzz, $this->signer, 'http://base.url');

        $result = $client->uploadByUrl('http://upload.url');

        $this->assertInstanceOf('Devmachine\Bundle\OntheioBundle\Client\Image\Result', $result);
        $this->assertEquals('http://base.url', $this->request->getHost());
        $this->assertEquals('/upload.php?app=key&s=4880768bfa54ae301b69770b79190e40', $this->request->getResource());
        $this->assertEquals(['url' => 'http://upload.url'], $this->request->getContent());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUploadByFileExpectsValidFile()
    {
        (new ImageClient($this->buzz, $this->signer, 'http://base.url'))->uploadByFile('no-such-file');
    }

    public function testUploadByFile()
    {
        $client = new ImageClient($this->buzz, $this->signer, 'http://base.url');

        $result = $client->uploadByFile($file = tempnam(sys_get_temp_dir(), 'image_'));

        $this->assertInstanceOf('Devmachine\Bundle\OntheioBundle\Client\Image\Result', $result);
        $this->assertEquals('http://base.url', $this->request->getHost());
        $this->assertEquals('/upload.php?app=key&s=4ca8dbe87d76306ae00cce35967b619b', $this->request->getResource());

        $this->assertInstanceOf('Buzz\Message\Form\FormRequest', $this->request);
        $this->assertInstanceOf('Buzz\Message\Form\FormUpload', $this->request->getFields()['file']);
        $this->assertEquals($file, $this->request->getFields()['file']->getFile());
    }

    private function makeMock($originalClassName)
    {
        if (method_exists($this, 'createMock')) {
            return $this->createMock($originalClassName);
        }

        return $this->getMock($originalClassName);
    }
}
