<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

use Buzz\Browser;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Form\FormUpload;
use Buzz\Message\MessageInterface;
use Symfony\Component\HttpFoundation\Response;

class ImageClient implements Uploader, Manipulator
{
    private $buzz;
    private $signer;
    private $baseUrl;

    public function __construct(Browser $buzz, Signer $signer, $baseUrl)
    {
        $this->buzz    = $buzz;
        $this->signer  = $signer;
        $this->baseUrl = $baseUrl;
    }

    public function uploadByUrl($url)
    {
        $query = http_build_query([
            'app' => $this->signer->getKey(),
            's' => $this->signer->sign($url),
        ]);

        $response = $this->buzz->post($this->baseUrl.'/upload.php?'.$query, [], ['url' => $url]);

        return $this->createResult($response);
    }

    public function uploadByFile($path)
    {
        if (!is_file($path)) {
            throw new \RuntimeException(sprintf('File "%s" not found.', $path));
        }

        $query = http_build_query([
            'app' => $this->signer->getKey(),
            's' => $this->signer->sign(file_get_contents($path)),
        ]);

        $request = new FormRequest();
        $request->fromUrl($this->baseUrl.'/upload.php?'.$query);
        $request->setField('file', new FormUpload($path));

        $response = $this->buzz->send($request);

        return $this->createResult($response);
    }

    public function rotate($key, $angle)
    {
        return $this->transform($key.'.d'.$angle);
    }

    public function delete($key, $thumb = null)
    {
        return $this->transform($key.($thumb ? '.'.$thumb : '').'.delete');
    }

    private function transform($url)
    {
        $url = sprintf('%s/%s.%s.jpg', $this->baseUrl, $url, $this->signer->signSimple($url));

        /** @var \Buzz\Message\Response $response */
        $response = $this->buzz->get($url);

        $headers = [];
        foreach (array_slice($response->getHeaders(), 1) as $header) {
            list($key, $value) = explode(':', $header, 2);
            $headers[$key] = $value;
        }

        return Response::create($response->getContent(), $response->getStatusCode(), $headers);
    }

    /**
     * @param MessageInterface $response
     *
     * @return Result
     */
    private function createResult(MessageInterface $response)
    {
        $data = json_decode($response->getContent(), true);

        return Result::create($data);
    }
}
