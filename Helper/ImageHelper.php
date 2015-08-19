<?php

namespace Devmachine\Bundle\OntheioBundle\Helper;

use Devmachine\Bundle\OntheioBundle\Client\Image\Signer;

class ImageHelper
{
    private $signer;
    private $baseUrl;

    public function __construct(Signer $signer, $baseUrl)
    {
        $this->signer = $signer;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function url($key)
    {
        return sprintf('%s/%s.%s.jpg', $this->baseUrl, $key, $this->signer->signSimple($key));
    }

    /**
     * @param string $key
     * @param int    $width
     * @param int    $height
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function resizeUrl($key, $width = null, $height = null)
    {
        if (!$width && !$height) {
            throw new \InvalidArgumentException('Either width or height must be set for the key.');
        }

        return $this->url($key.'.r'.$width.'x'.$height);
    }

    /**
     * @param string $key
     * @param int    $width
     * @param int    $height
     * @param int    $left
     * @param int    $top
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function cropUrl($key, $width, $height, $left, $top)
    {
        if (!$width || !$height) {
            throw new \InvalidArgumentException('Width and height must be set for the key.');
        }

        return $this->url($key.'.c'.$width.'x'.$height.'x'.$left.'x'.$top);
    }
}
