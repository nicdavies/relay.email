<?php

namespace App\Support\Services\Api;

use Curl\Curl;
use ErrorException;

abstract class AbstractApiClient
{
    /** @var Curl $client */
    private Curl $client;

    /** @var string|null $endpoint */
    private ?string $endpoint;

    /** @var string|null $clientSecret */
    private ?string $clientSecret;

    /**
     * AbstractApiClient constructor.
     * @param string $endpoint
     * @param string $clientSecret
     * @throws ErrorException
     */
    public function __construct(
        string $endpoint,
        string $clientSecret = ''
    ) {
        $this->setEndpoint($endpoint);
        $this->setClientSecret($clientSecret);

        $this->init();
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function get(string $endpoint, array $data = [])
    {
        return $this->doApiRequest($endpoint, 'GET', $data);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function post(string $endpoint, array $data = [])
    {
        return $this->doApiRequest($endpoint, 'POST', $data);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function put(string $endpoint, array $data = [])
    {
        return $this->doApiRequest($endpoint, 'PUT', $data);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function patch(string $endpoint, array $data = [])
    {
        return $this->doApiRequest($endpoint, 'PATCH', $data);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    protected function delete(string $endpoint, array $data = [])
    {
        return $this->doApiRequest($endpoint, 'DELETE', $data);
    }

    /**
     * @return void
     * @throws ErrorException
     */
    public function init() : void
    {
        /** @var Curl $curl */
        $curl = new Curl();

        $curl->setHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);

        $curl->setUserAgent(config('app.name'));
        $this->setClient($curl);
        $this->setBearerTokenHeader();
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return mixed
     */
    private function doApiRequest(string $endpoint, string $method, array $data = [])
    {
        $endpoint = $this->getEndpoint() . $endpoint;

        switch (strtolower($method)) {
            case 'get':
                if (! empty($data)) {
                    $this->getClient()->get($endpoint. '?' . http_build_query($data));
                } else {
                    $this->getClient()->get($endpoint);
                }
                break;

            case 'post':
                if (! empty($data)) {
                    $this->getClient()->post($endpoint, $data);
                } else {
                    $this->getClient()->post($endpoint);
                }
                break;

            case 'put':
                if (! empty($data)) {
                    $this->getClient()->put($endpoint, $data);
                } else {
                    $this->getClient()->put($endpoint);
                }
                break;

            case 'patch':
                if (! empty($data)) {
                    $this->getClient()->patch($endpoint, $data);
                } else {
                    $this->getClient()->patch($endpoint);
                }
                break;

            case 'delete':
                if (! empty($data)) {
                    $this->getClient()->delete($endpoint, [], $data);
                } else {
                    $this->getClient()->delete($endpoint);
                }
                break;
        }

        $this->hasError   = $this->getClient()->error;
        $this->statusCode = $this->getClient()->httpStatusCode;

        return json_decode(json_encode($this->getClient()->response, JSON_THROW_ON_ERROR, 512), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Simply sets the authorization header to use the bearer token.
     * @return void
     */
    private function setBearerTokenHeader() : void
    {
        $token = session('bearer', null);

        if (! empty($token)) {
            $this->getClient()->setHeader('Authorization', 'Bearer ' . $token);
        }
    }

    # --------------------------------------------------------------------
    # GETTERS AND SETTERS
    # --------------------------------------------------------------------

    /**
     * @return Curl
     */
    public function getClient() : Curl
    {
        return $this->client;
    }

    /**
     * @param Curl $curl
     * @return $this
     */
    public function setClient(Curl $curl) : self
    {
        $this->client = $curl;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret() : string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setClientSecret(string $secret) : self
    {
        $this->clientSecret = $secret;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint() : string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     * @return $this
     */
    public function setEndpoint(string $endpoint) : self
    {
        $this->endpoint = $endpoint;
        return $this;
    }
}
