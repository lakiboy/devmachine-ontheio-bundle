<?php

namespace Devmachine\Bundle\OntheioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImageController extends Controller
{
    /**
     * @Route("/{key}/rotate/{angle}")
     *
     * @param string $key
     * @param int    $angle
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rotateAction($key, $angle)
    {
        return $this->getManipulator()->rotate($key, $angle);
    }

    /**
     * @Route("/{key}/delete/{thumb}")
     *
     * @param string $key
     * @param string $thumb
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($key, $thumb = null)
    {
        return $this->getManipulator()->delete($key, $thumb);
    }

    /**
     * @return \Devmachine\Bundle\OntheioBundle\Client\Image\Manipulator
     */
    private function getManipulator()
    {
        return $this->get('devmachine_ontheio.client.image');
    }
}
