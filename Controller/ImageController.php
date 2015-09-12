<?php

namespace Devmachine\Bundle\OntheioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->getClient()->rotate($key, $angle);
    }

    /**
     * @Route("/{key}/delete/{thumb}")
     *
     * @param string $key
     * @param string $thumb
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($key, $thumb = null)
    {
        return $this->getClient()->delete($key, $thumb);
    }

    /**
     * @Route("/thumbnail")
     * @Method("POST")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function thumbnailAction(Request $request)
    {
        $url = $request->request->get('url');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return Response::create('', Response::HTTP_BAD_REQUEST);
        }

        $result = [
            'key'          => null,
            'width'        => null,
            'height'       => null,
            'original_url' => $url,
            'error'        => null,
        ];

        try {
            $image = $this->getClient()->uploadByUrl($url);

            $result['key']    = $image->getKey();
            $result['width']  = $image->getWidth();
            $result['height'] = $image->getHeight();
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }

        /** @var \Twig_Template $template */
        $template = $this->get('twig')->loadTemplate('DevmachineOntheioBundle:Form:form_layout.html.twig');

        $html = $template->renderBlock('devmachine_ontheio_image_thumbnail', [
            'thumb_width'        => $request->query->get('width'),
            'thumb_height'       => $request->query->get('height'),
            'translation_domain' => $request->query->get('trans_domain'),
            'image'              => $result,
        ]);

        return JsonResponse::create(['html' => $html, 'image' => $result]);
    }

    /**
     * @return \Devmachine\Bundle\OntheioBundle\Client\Image\ImageClient
     */
    private function getClient()
    {
        return $this->get('devmachine_ontheio.client.image');
    }
}
