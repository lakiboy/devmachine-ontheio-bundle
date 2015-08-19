<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

class Result
{
    private $key;
    private $width;
    private $height;
    private $url;
    private $new;

    /**
     * @param array $data
     *
     * @return self
     */
    public static function create(array $data)
    {
        list($width, $height) = explode('x', $data['size']);

        return new static($data['key'], $width, $height, $data['full_size'], empty($data['uploaded_before']));
    }

    public function __construct($key, $width, $height, $url, $new)
    {
        $this->key = $key;
        $this->width = $width;
        $this->height = $height;
        $this->url = $url;
        $this->new = $new;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->new;
    }

    public function getSize()
    {
        return sprintf('%dx%d', $this->width, $this->height);
    }
}
