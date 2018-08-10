<?php

namespace Tests\Feature;

use App\JobRequest;
use App\Transformers\JobRequestTransformer;
use App\User;
use Tests\TestCase;

class ShowJobRequestTest extends TestCase
{
    /**
     * Sends get request to show a job request.
     *
     * @param JobRequest $jobRequest
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function hitShowRequestEndpoint(JobRequest $jobRequest): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->get(route('showRequest', ['jobRequest' => $jobRequest->id]));
        return $response;
    }

    /** @test */
    function a_user_can_see_a_request()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $request = factory(JobRequest::class)->create();

        $response = $this->hitShowRequestEndpoint($request);

        $response->assertStatus(200);

        $response->assertJson(\Fractal::item($request, new JobRequestTransformer())
            ->parseIncludes(['user'])->toArray());
    }

    /** @test */
    function a_guest_cannot_see_a_request()
    {
        $request = factory(JobRequest::class)->create();

        $response = $this->hitShowRequestEndpoint($request);

        $response->assertStatus(401);
    }
}
