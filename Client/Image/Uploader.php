<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

interface Uploader
{
    /**
     * @param string $url
     *
     * @return \Devmachine\Bundle\OntheioBundle\Client\Image\Result
     */
    public function uploadByUrl($url);

    /**
     * @param string $path
     *
     * @return \Devmachine\Bundle\OntheioBundle\Client\Image\Result
     */
    public function uploadByFile($path);
}
