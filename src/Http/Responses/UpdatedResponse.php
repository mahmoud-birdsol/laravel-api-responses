<?php

namespace Alacrity\Responses\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class UpdatedResponse extends ApiResponse
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        if($this->wantsModel()){
            return $this->responseWithModel(202);
        }

        return response()->json(['message' => 'success'], 202);
    }

    /**
     * Return a response with model.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseWithModel($statusCode = 200): \Illuminate\Http\JsonResponse
    {
        return fractal($this->model)
            ->transformWith($this->transformer)
            ->respond($statusCode, [], JSON_PRETTY_PRINT);
    }
}