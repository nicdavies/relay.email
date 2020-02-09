<?php

namespace App\Http\Resources\Pgp;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PgpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return parent::toArray($request);
    }
}
