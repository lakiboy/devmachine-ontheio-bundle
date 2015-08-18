<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

class Signer
{
    private $key;
    private $secret;

    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    public function sign($content)
    {
        return md5($this->key.$content.$this->secret);
    }

    public function getKey()
    {
        return $this->key;
    }
}
