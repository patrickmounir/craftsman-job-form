<?php

namespace App\Http\Controllers;

use App\JobRequest;
use App\Transformers\JobRequestTransformer;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function store(Request $request)
    {
        $jobRequest = JobRequest::create($request->except('user_id')+['user_id' => \Auth::user()->id]);

        $transformedData = \Fractal::item($jobRequest, new JobRequestTransformer())->toArray();

        return response()->json($transformedData)->setStatusCode(201);
    }
}
