<?php
/**
 * Author: Richard Green
 * Date: 28/09/2016
 * Time: 4:05 PM
 */

namespace JsonRpc;

use JsonRpc\Parser;
use JsonRpc\Protocol\HttpClient;
use JsonRpc\Validator\JsonFormatValidator;
use JsonRpc\Validator\JsonEncodingValidator;
use JsonRpc\Validator\JsonRpcFormatValidator;
use JsonRpc\Validator\JsonRpcResponseFormatValidator;

class Client
{
    const VERSION = "2.0";

    /**
     * @var null
     */
    protected $id = null;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var mixed
     */
    protected $params;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var array
     */
    protected $validators;

    /**
     * Client constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->httpClient = new HttpClient($url);

        $this->validators = [
            'jsonEncoding' => new JsonEncodingValidator(),
            'jsonFormat' => new JsonFormatValidator(),
            'jsonRpcFormat' => new JsonRpcFormatValidator(),
            'jsonRpcResponseFormat' => new JsonRpcResponseFormatValidator()
        ];
    }

    /**
     * @param $id
     * @param $method
     * @param array $data
     */
    public function request($id, $method, Array $params)
    {
        $this->id = $id;
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @param $method
     */
    public function notification($method)
    {
        $this->method = $method;
    }

    /**
     * @param $response
     * @return mixed
     */
    public function response($response)
    {
        $response = $this->decode($response);

        $this->validators['jsonRpcResponseFormat']->validate($response);

        return $response;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        $payload = $this->buildPayload();
        $response = $this->httpClient->send($payload);

        $result = $this->response($response);

        return $result;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function buildPayload()
    {
        if (!$this->method) {
            throw new \Exception('JSON-RPC method not set');
        }

        $payload = [
            "jsonrpc" => self::VERSION,
            "method" => $this->method,
            "id" => $this->id
        ];

        if ($this->params) {
            $payload['params'] = $this->params;
        }

        return $this->encode($payload);
    }

    /**
     * @return string
     */
    private function encode($payload)
    {
        $this->validators['jsonFormat']->validate($payload);

        return json_encode($payload);
    }

    /**
     * @param $result
     * @return mixed
     */
    private function decode($response)
    {
        $result = json_decode($response, true);
        $jsonLastError = json_last_error();

        $this->validators['jsonEncoding']->validate($jsonLastError);
        $this->validators['jsonRpcResponseFormat']->validate($result);

        return $result;
    }
}