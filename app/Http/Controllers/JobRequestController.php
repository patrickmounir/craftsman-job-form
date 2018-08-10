<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Responses\ResponsesInterface;
use App\JobRequest;
use App\Providers\ApiServiceProvider;
use App\Transformers\JobRequestTransformer;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    /**
     * @var ResponsesInterface $responder
     */
    private $responder;

    /**
     * JobRequestController constructor.
     *
     * @param ResponsesInterface $responses
     */
    public function __construct(ResponsesInterface $responses)
    {
        $this->middleware('auth:api');
        $this->responder = $responses;
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

        return $this->responder->setStatusCode(201)->respond($transformedData);
    }

    /**
     * Handles request to list job requests.
     *
     * @return $this
     */
    public function index()
    {
        $jobRequestPaginate = JobRequest::where('user_id', '!=', \Auth::user()->id)
                        ->paginate(ApiServiceProvider::$itemsPerPage);

        $transformedData = \Fractal::collection($jobRequestPaginate->items(), new JobRequestTransformer())
            ->parseIncludes(['user'])
            ->toArray();

        return $this->responder->respondWithPagination($jobRequestPaginate, $transformedData);
    }
}
