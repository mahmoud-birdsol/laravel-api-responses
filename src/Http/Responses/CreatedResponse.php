<?php

namespace Alacrity\Responses\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class CreatedResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json(['message' => 'success'], 201);
    }
}