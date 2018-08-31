<?php

namespace Alacrity\Responses\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class ShowResponse implements Responsable
{
    /**
     * The model to be transformed.
     *
     * @var Model
     */
    private $model;

    /**
     * The specified model transformer.
     *
     * @var TransformerAbstract
     */
    private $transformer;

    /**
     * ShowResponse constructor.
     *
     * @param Model               $model
     * @param TransformerAbstract $transformer
     */
    public function __construct(Model $model, TransformerAbstract $transformer)
    {

        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return fractal($this->model->refresh())
            ->transformWith($this->transformer)
            ->respond(200, [], JSON_PRETTY_PRINT);

    }
}