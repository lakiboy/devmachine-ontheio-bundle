<?php

namespace Devmachine\Bundle\OntheioBundle\Tests\Twig;

use Devmachine\Bundle\OntheioBundle\Twig\ImageExtension;

class ImageExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUrlProxiesToUrl()
    {
        $helper = $this->getImageHelper();
        $helper
            ->expects($this->once())
            ->method('url')
            ->with($this->equalTo('key'))
        ;

        (new ImageExtension($helper))->getUrl('key');
    }

    public function testGetUrlProxiesToCropUrl()
    {
        $helper = $this->getImageHelper();
        $helper
            ->expects($this->once())
            ->method('cropUrl')
            ->with($this->equalTo('key'), $this->equalTo(200), $this->equalTo(150), $this->equalTo(20), $this->equalTo(15))
        ;

        (new ImageExtension($helper))->getUrl('key', 200, 150, 20, 15);
    }

    public function testGetUrlProxiesToResizeUrl()
    {
        $helper = $this->getImageHelper();
        $helper
            ->expects($this->once())
            ->method('resizeUrl')
            ->with($this->equalTo('key'), $this->equalTo(200), $this->equalTo(150))
        ;

        (new ImageExtension($helper))->getUrl('key', 200, 150);
    }

    private function getImageHelper()
    {
        return $this->getMockBuilder('Devmachine\Bundle\OntheioBundle\Helper\ImageHelper')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
