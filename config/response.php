<?php

/**
 * Api responses configuration.
 */

return [
    /*
     * Pagination config variables.
     */
    'pagination_adapter' 	 	  => \League\Fractal\Pagination\IlluminatePaginatorAdapter::class,
    'pagination_request_key' 	  => 'paginate',
];
