<?php

namespace App\Support\Services\Api;

use Exception;
use ErrorException;
use App\Support\Services\Api\Endpoints;

class Client extends AbstractApiClient
{
    /**
     * Client constructor.
     * @param string $endpoint
     * @param string $clientSecret
     * @throws ErrorException
     */
    public function __construct(
        string $endpoint,
        string $clientSecret = ''
    ) {
        parent::__construct($clientSecret, $endpoint);
    }

    /**
     * @param string $name
     * @return Endpoints\Account
     * @throws Exception
     */
    public function api(string $name)
    {
        $constructorArgs = [
            $this->getEndpoint(),
            $this->getClientSecret(),
        ];

        switch ($name) {
            case 'me':
            case 'user':
            case 'account':
                $class = new Endpoints\Account(...$constructorArgs);
                break;

            default:
                throw new Exception(sprintf(
                    'Unknown class, tried to call %s',
                    $name
                ));
        }

        return $class;
    }
}
