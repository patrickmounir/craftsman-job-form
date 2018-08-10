<?php

namespace Tests\Feature;

use App\JobRequest;
use App\Transformers\JobRequestTransformer;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;

class ListAvailableJobRequestsTest extends TestCase
{
    /** @test */
    function a_user_can_see_all_job_requests_but_his_own_requests()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $otherRequests = factory(JobRequest::class, 2)->create();

        $usersJobRequest= factory(JobRequest::class)->create(['title' => 'UsersLogged In', 'user_id' => $user->id]);

        $requestCreatedMoreThan30DaysAgo = factory(JobRequest::class)->create([
            'title' => 'More than 30 Days',
            'deadline' => Carbon::today()->subDays(31)
        ]);

        $response = $this->get(route('listJobRequests'));

        $response->assertStatus(200);

        $response->assertJson(fractal($otherRequests, new JobRequestTransformer())->parseIncludes('user')->toArray());

        $response->assertJsonMissing([
            'id' => $usersJobRequest->id,
            'title' => $usersJobRequest->title,
        ]);

        $response->assertJsonMissing([
            'id' => $requestCreatedMoreThan30DaysAgo->id,
            'title' => $requestCreatedMoreThan30DaysAgo->title,
        ]);
    }
}
