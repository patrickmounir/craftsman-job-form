<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class JobRequestFilter extends QueryFilter
{

    /**
     * Filters Job requests by services.
     *
     * @param $value
     *
     * @return Builder
     */
    public function service($value)
    {
        return $this->builder->where('service_id', $value);
    }

    /**
     * Filters Job requests by region.
     *
     * @param $value
     *
     * @return Builder
     */
    public function region($value)
    {
        return $this->builder->where('city', $value);
    }
}