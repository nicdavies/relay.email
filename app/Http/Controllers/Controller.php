<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param bool $assertion
     * @param string $message
     * @param int $code
     * @return void
     */
    public function assert(bool $assertion, string $message = 'Permission Denied', int $code = 403) : void
    {
        if (! $assertion) {
            $this->unauthorizedException($message, $code);
        }
    }

    /**
     * @param string $message
     * @param int $code
     * @return void
     */
    public function unauthorizedException(string $message = 'Permission Denied', int $code = 403) : void
    {
        throw new UnauthorizedException($message, $code);
    }
}
