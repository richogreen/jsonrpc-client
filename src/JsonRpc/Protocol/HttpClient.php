<?php
/**
 * Author: Richard Green
 * Date: 28/09/2016
 * Time: 4:37 PM
 */

namespace JsonRpc\Protocol;

use JsonRpc\Exception\HttpConnectionException;

class HttpClient
{
    /**
     * @var string
     */
    private $method = 'POST';

    /**
     * @var string
     */
    private $contentType = 'application/json';

    /**
     * @var string
     */
    private $connectionType = 'close';

    /**
     * @var int
     */
    private $timeout = 10;

    /**
     * @var int
     */
    private $maxRedirects = 1;

    /**
     * @var string
     */
    private $url;

    /**
     * Socket constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param $payload
     */
    public function send($payload)
    {
        $this->setHeaders(strlen($payload));
        $context = $this->setContext($payload);

        try {
            $stream = fopen($this->url, 'r', false, $context);

            if (!is_resource($stream)) {
                throw new HttpConnectionException("Unable to open connection");
            }

            $response = stream_get_contents($stream);

            if ($response === false) {
                return null;
            }

            fclose($stream);

            return $response;
        } catch (HttpConnectionException $e) {
            throw new HttpConnectionException("Unable to connect. ".$e->getMessage());
        }
    }

    /**
     * @return array
     */
    private function setHeaders($contentLength)
    {
        $this->headers = [
            "User-Agent: Simple JSON-RPC PHP Client",
            "Content-Type: $this->contentType",
            "Accept: $this->contentType",
            "Connection: $this->connectionType",
            "Content-Length: $contentLength"
        ];
    }

    /**
     * @param $content
     * @return resource
     */
    private function setContext($content)
    {
        $options = [
            'http' => [
                'method' => $this->method,
                'timeout' => $this->timeout,
                'max_redirects' => $this->maxRedirects,
                'header' => $this->headers,
                'content' => $content,
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ]
        ];

        return stream_context_create($options);
    }
}