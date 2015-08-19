<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

interface Manipulator
{
    /**
     * @param string $key
     * @param int    $angle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rotate($key, $angle);

    /**
     * @param string $key
     * @param string $thumb
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($key, $thumb = null);
}
