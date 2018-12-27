<?php

namespace Alacrity\Responses\Http\Responses;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Illuminate\Contracts\Support\Responsable;

abstract class ApiResponse implements Responsable
{
    /**
     * The model to be transformed.
     *
     * @var Model
     */
    protected $model;

    /**
     * The specified model transformer.
     *
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * ShowResponse constructor.
     *
     * @param Model               $model
     * @param TransformerAbstract $transformer
     */
    public function __construct(Model $model = null, TransformerAbstract $transformer = null)
    {
        if (! is_null($model) && ! is_null($transformer)) {
            $this->model = $model;
            $this->transformer = $transformer;
        }
    }

    /**
     * Check if the user wants the model included in the response.
     *
     * @return bool
     */
    protected function wantsModel()
    {
        return isset($this->model) && isset($this->transformer);
    }
}
