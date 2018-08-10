<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\JobRequest;
use App\Transformers\JobRequestTransformer;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    /**
     * JobRequestController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Handles request to store a job request.
     *
     * @param CreateJobRequest $request
     *
     * @return $this
     */
    public function store(CreateJobRequest $request)
    {
        $jobRequest = JobRequest::create($request->except('user_id')+['user_id' => \Auth::user()->id]);

        $transformedData = \Fractal::item($jobRequest, new JobRequestTransformer())->toArray();

        return response()->json($transformedData)->setStatusCode(201);
    }
}
