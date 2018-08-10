<?php

namespace App\Queries;

use App\Filters\JobRequestFilter;
use App\JobRequest;
use App\Providers\ApiServiceProvider;
use Carbon\Carbon;

class AvailableJobRequest
{

    /**
     * @var JobRequestFilter
     */
    private $filter;

    /**
     * JobRequestQuery constructor.
     *
     * @param JobRequestFilter $filter
     */
    public function __construct(JobRequestFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Returns the available job requests.
     *
     * @return mixed
     */
    public function query()
    {
        return JobRequest::where('user_id', '!=', \Auth::user()->id)
            ->whereDate('created_at', '>=', Carbon::today()->subDays(30)->format('Y-m-d'))
            ->filter($this->filter)
            ->paginate(ApiServiceProvider::$itemsPerPage);
    }
}