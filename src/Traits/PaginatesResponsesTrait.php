<?php

namespace Alacrity\Responses\Traits;

use League\Fractal\Pagination\PaginatorInterface;

trait PaginatesResponsesTrait
{
    /**
     * The pagination adapter class name.
     *
     * @var PaginatorInterface
     */
    protected $paginationAdapter;

    /**
     * Create an HTTP response that represents the object with pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toPaginatedResponse($request)
    {
        // Add pagination to the query builder.
        $this->buildPagination($request);

        // Set the pagination adapter class name.
        $this->setPaginationAdapter();

        // Respond with the transformed paginated date.
        return fractal($this->builder)
            ->transformWith($this->transformer)
            ->paginateWith(new $this->paginationAdapter($this->builder))
            ->respond(200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Check if the request has a pagination value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasPagination($request)
    {
        return $request->has(config('response.pagination_request_key'));
    }

    /**
     * Add paginate to the eloquent query builder.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildPagination($request)
    {
        $this->builder = $this->builder->paginate($this->getPagination($request));
    }

    /**
     * Get the paginate value.
     *
     * @param  \Illuminate\Http\Request $request
     * @return int
     */
    protected function getPagination($request)
    {
        return $request->input(config('response.pagination_request_key'));
    }

    /**
     * Set the pagination adapter class name.
     */
    protected function setPaginationAdapter()
    {
        $this->paginationAdapter = config('response.pagination_adapter');
    }
}
