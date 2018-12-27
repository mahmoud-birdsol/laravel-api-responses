<?php

namespace Alacrity\Responses\Traits;

trait FiltersListsTrait
{
    /**
     * Build query scope filters if exist.
     *
     * @param $request
     * @return $this
     */
    protected function buildFilters($request)
    {
        foreach ($this->getFilters($request) as $filter => $value) {
            $this->attachFilter($filter, $value);
        }

        return $this;
    }

    /**
     * Get the input filters.
     *
     * @return array
     */
    private function getFilters($request)
    {
        return $request->except(['query', 'paginate']);
    }

    /**
     * Attach filter to query builder.
     *
     * @param $filter
     * @param $value
     */
    private function attachFilter($filter, $value)
    {
        if ($this->isValidFilter($filter, $value)) {
            $this->builder = $this->builder->{$filter}($value);
        }
    }

    /**
     * Parse the input filter name to the model method name.
     *
     * @param $filter
     * @return string
     */
    private function parseFilterNameToMethod($filter)
    {
        return 'scope'.ucfirst($filter);
    }

    /**
     * Check if method is a valid filter.
     *
     * @param $filter
     * @param $value
     * @return bool
     */
    private function isValidFilter($filter, $value)
    {
        return
            $this->filterExists($filter) &&
            $this->filterValueExists($value);
    }

    /**
     * Check if the filter exists on the model.
     *
     * @param $filter
     * @return bool
     */
    private function filterExists($filter)
    {
        return method_exists(
            $this->builder->getModel(),
            $this->parseFilterNameToMethod($filter)
        );
    }

    /**
     * Check if the filter value exists.
     *
     * @param $value
     * @return bool
     */
    private function filterValueExists($value)
    {
        return ! empty($value);
    }
}
