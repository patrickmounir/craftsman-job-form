<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponsesInterface;
use App\Service;
use App\Transformers\ServiceTransformer;

class ServiceController extends Controller
{
    /**
     * @var ResponsesInterface $responder
     */
    private $responder;

    /**
     * ServiceController constructor.
     *
     * @param ResponsesInterface $responses
     */
    public function __construct(ResponsesInterface $responses)
    {
        $this->middleware('auth:api');
        $this->responder = $responses;
    }

    /**
     * Handles requests to list services.
     *
     * @return $this
     */
    public function index()
    {
        $services = Service::all();

        $transformedData = \Fractal::collection($services, new ServiceTransformer())->toArray();

        return $this->responder->respond($transformedData);
    }
}
