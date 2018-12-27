<?php

namespace Alacrity\Responses;

use Alacrity\Responses\Http\Responses\CreatedResponse;
use Alacrity\Responses\Http\Responses\DeletedResponse;
use Alacrity\Responses\Http\Responses\IndexResponse;
use Alacrity\Responses\Http\Responses\ShowResponse;
use Alacrity\Responses\Http\Responses\UpdatedResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

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
     * @return ShowResponse
     */
    public function show()
    {
        return new ShowResponse($this->model, $this->transformer);
    }

    /**
     * Return a created response.
     *
     * @return CreatedResponse
     */
    public function created()
    {
        return new CreatedResponse($this->model, $this->transformer);
    }

    /**
     * Return an updated response.
     *
     * @return UpdatedResponse
     */
    public function updated()
    {
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
}