<?php

namespace App\Traits;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{

    /**
     * Apply the filter on the query.
     *
     * @param Builder $query
     * @param QueryFilter $filter
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, QueryFilter $filter)
    {
        return $filter->apply($query);
    }
}