<?php

namespace Devmachine\Bundle\OntheioBundle\Client\Image;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Form\FormUpload;
use Buzz\Message\MessageInterface;

class BuzzClient implements Client
{
    private $buzz;
    private $signer;
    private $baseUrl;

    public function __construct(array $options, Browser $buzz = null)
    {
        if (!$buzz) {
            $adapter = new Curl();
            $adapter->setTimeout(10);
            $buzz = new Browser($adapter);
        }

        $this->buzz    = $buzz;
        $this->signer  = new Signer($options['key'], $options['secret']);
        $this->baseUrl = $options['base_url'];
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
