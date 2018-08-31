<?php

namespace Alacrity\Responses\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;

class IndexResponse implements Responsable
{
	/**
	 * The response resource builder
	 *
	 * @var Builder
	 */
	protected $builder;
	protected $transformer;

	/**
	 * Index response constructor.
	 *
	 * @param Builder
	 */
	public function __construct(Builder $builder, TransformerAbstract $transformer)
	{
		$this->builder = $builder;
		$this->transformer = $transformer;
	}

	/**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function toResponse($request)
	{
		if ($this->hasPagination($request)) {
            return $this->toPaginatedResponse($request);
        }

        return fractal($this->builder->get())
        	->transformWith($this->transformer)
        	->respond(200, [], JSON_PRETTY_PRINT);
	}

	/**
     * Create an HTTP response that represents the object with pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function toPaginatedResponse($request)
	{
		$this->buildPagination($request);

		return fractal($this->builder)
			->transformWith($this->transformer)
        	->paginateWith(new IlluminatePaginatorAdapter($this->builder))
        	->respond(200, [], JSON_PRETTY_PRINT);
	}

	/**
	 * Check if the request has a pagination value.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return boolean
	 */
	private function hasPagination($request)
	{
		return $request->has('paginate');
	}

	/**
	 * Add paginate to the eloquent query builder.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
    private function buildPagination($request)
    {
        $this->builder = $this->builder->paginate($this->getPagination($request));
    }

    /**
     * Get the paginate value.
     *
     * @param  \Illuminate\Http\Request $request
     * @return integer
     */
    private function getPagination($request)
    {
    	return $request->input('paginate');
    }
}
