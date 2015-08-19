<?php

namespace Devmachine\Bundle\OntheioBundle\Twig;

use Devmachine\Bundle\OntheioBundle\Helper\ImageHelper;

class ImageExtension extends \Twig_Extension
{
    private $helper;

    public function __construct(ImageHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getName()
    {
        return 'devmachine_ontheio_image';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('devmachine_ontheio_image_url', [$this, 'getUrl']),
        ];
    }

    public function getUrl($key, $width = null, $height = null, $left = null, $top = null)
    {
        // Original.
        if (!$width && !$height) {
            return $this->helper->url($key);
        }

        // Crop.
        if ($left) {
            return $this->helper->cropUrl($key, $width, $height, $left, $top);
        }

        // Resize.
        return $this->helper->resizeUrl($key, $width, $height);
    }
}
