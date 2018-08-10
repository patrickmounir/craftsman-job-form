<?php

namespace App\Http\Controllers;

use App\JobRequest;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function store(Request $request)
    {
        JobRequest::create($request->except('user_id')+['user_id' => \Auth::user()->id]);

        return response()->json()->setStatusCode(201);
    }
}
