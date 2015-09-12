<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\Helper;

use Devmachine\Bundle\OntheioBundle\Helper\ImageHelper;

class ImageHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testUrl()
    {
        $signer = $this->getSigner();
        $signer
            ->expects($this->once())
            ->method('signSimple')
            ->with($this->equalTo('key'))
            ->willReturn('signature')
        ;

        $helper = new ImageHelper($signer, 'http://base.url');

        $this->assertEquals('http://base.url/key.signature.jpg', $helper->url('key'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testResizeUrlArgs()
    {
        $helper = new ImageHelper($this->getSigner(), 'http://base.url');
        $helper->resizeUrl('key');
    }

    public function testResizeUrl()
    {
        $signer = $this->getSigner();
        $signer
            ->expects($this->exactly(3))
            ->method('signSimple')
            ->willReturn('signature')
        ;

        $helper = new ImageHelper($signer, 'http://base.url');

        $this->assertEquals('http://base.url/key.r200x.signature.jpg', $helper->resizeUrl('key', 200));
        $this->assertEquals('http://base.url/key.rx200.signature.jpg', $helper->resizeUrl('key', null, 200));
        $this->assertEquals('http://base.url/key.r200x150.signature.jpg', $helper->resizeUrl('key', 200, 150));
    }

    public function testCropUrl()
    {
        $signer = $this->getSigner();
        $signer
            ->expects($this->once())
            ->method('signSimple')
            ->with($this->equalTo('key.c200x150x20x15'))
            ->willReturn('signature')
        ;

        $helper = new ImageHelper($signer, 'http://base.url');

        $this->assertEquals('http://base.url/key.c200x150x20x15.signature.jpg', $helper->cropUrl('key', 200, 150, 20, 15));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getSigner()
    {
        return $this->getMockBuilder('Devmachine\Bundle\OntheioBundle\Client\Image\Signer')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
