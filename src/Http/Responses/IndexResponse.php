<?php

namespace Alacrity\Responses\Http\Responses;

use Alacrity\Responses\Traits\FiltersListsTrait;
use Alacrity\Responses\Traits\PaginatesResponsesTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use League\Fractal\TransformerAbstract;

class IndexResponse implements Responsable
{
	use PaginatesResponsesTrait, FiltersListsTrait;

	/**
	 * The response resource builder
	 *
	 * @var Builder
	 */
	protected $builder;

	/**
	 * The model transformer class
	 *
	 * @var TransformerAbstract
	 */
	protected $transformer;

	/**
	 * Index response constructor.
	 *
	 * @param Builder
     * @param TransformerAbstract
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
	    $this
            ->buildFilters($request)
            ->buildSorting($request);

		if ($this->hasPagination($request)) {
            return $this->toPaginatedResponse($request);
        }

        return fractal($this->builder->get())
        	->transformWith($this->transformer)
        	->respond(200, [], JSON_PRETTY_PRINT);
	}

    /**
     * Add sorting to the query builder.
     *
     * @param $request
     * @return $this
     */
    protected function buildSorting($request)
    {
        if($request->has('latest')){
            $this->builder = $this->builder->latest('created_at');
        }
        if($request->has('sortAsc')) {
            $this->builder = $this->builder->orderBy($request->sortAsc, 'asc');
        }
        if($request->has('sortDesc')) {
            $this->builder = $this->builder->orderBy($request->sortDesc, 'desc');
        }

        return $this;
    }
}
