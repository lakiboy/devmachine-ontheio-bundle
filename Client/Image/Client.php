<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

interface Client
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
