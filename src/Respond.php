<?php

namespace Alacrity\Responses;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Illuminate\Database\Eloquent\Builder;
use Alacrity\Responses\Http\Responses\ShowResponse;
use Alacrity\Responses\Http\Responses\IndexResponse;
use Alacrity\Responses\Http\Responses\CreatedResponse;
use Alacrity\Responses\Http\Responses\DeletedResponse;
use Alacrity\Responses\Http\Responses\UpdatedResponse;

class Respond
{
    /**
     * The specified model.
     *
     * @var Model
     */
    private $model;

    /**
     * The model transformer.
     *
     * @var TransformerAbstract
     */
    private $transformer;

    /**
     * Set the response model and transformer.
     *
     * @param Model               $model
     * @param TransformerAbstract $transformer
     * @return $this
     */
    public function with(Model $model, TransformerAbstract $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Return an index response.
     *
     * @param Builder             $builder
     * @param TransformerAbstract $transformer
     * @return IndexResponse
     */
    public function index(Builder $builder, TransformerAbstract $transformer)
    {
        return new IndexResponse($builder, $transformer);
    }

    /**
     * Return a show response.
     *
     * @param null $model
     * @param null $transformer
     * @return ShowResponse
     */
    public function show($model = null, $transformer = null)
    {
        $this->setModelAndTransformer($model, $transformer);

        return new ShowResponse($this->model, $this->transformer);
    }

    /**
     * Return a created response.
     *
     * @param null $model
     * @param null $transformer
     * @return CreatedResponse
     */
    public function created($model = null, $transformer = null)
    {
        $this->setModelAndTransformer($model, $transformer);

        return new CreatedResponse($this->model, $this->transformer);
    }

    /**
     * Return an updated response.
     *
     * @param null $model
     * @param null $transformer
     * @return UpdatedResponse
     */
    public function updated($model = null, $transformer = null)
    {
        $this->setModelAndTransformer($model, $transformer);

        return new UpdatedResponse($this->model, $this->transformer);
    }

    /**
     * Return a deleted response.
     *
     * @return DeletedResponse
     */
    public function deleted()
    {
        return new DeletedResponse();
    }

    /**
     * Set the response model and transformer
     *
     * @param Model|null $model
     * @param TransformerAbstract|null $transformer
     */
    private function setModelAndTransformer($model = null, $transformer = null)
    {
        if (!is_null($model) && !is_null($transformer)) {
            $this->model = $model;
            $this->transformer = $transformer;
        }
    }
}
