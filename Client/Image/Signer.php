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

    public function signSimple($content)
    {
        return substr(md5($content.$this->secret), 0, 8);
    }

    public function getKey()
    {
        return $this->key;
    }
}
