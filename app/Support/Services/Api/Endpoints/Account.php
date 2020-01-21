<?php

namespace App\Support\Services\Api\Endpoints;

use ErrorException;
use App\Support\Services\Api\AbstractApiClient;

class Account extends AbstractApiClient
{
    /**
     * Account constructor.
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
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function register(string $name, string $email, string $password)
    {
        return $this->post('/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $password,
        ]);
    }
}
