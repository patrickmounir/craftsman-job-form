<?php

namespace Tests\Feature\JobRequests;

use App\JobRequest;
use App\Service;
use App\Transformers\JobRequestTransformer;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;

class ListAvailableJobRequestsTest extends TestCase
{
    /**
     * Sends get request to get list all available job requests.
     *
     * @param string $query
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function hitListJobRequestEndpoint($query = ''): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->get(route('listJobRequests') . $query);
        return $response;
    }

    /** @test */
    function a_user_can_see_all_job_requests_but_his_own_requests()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $otherRequests = factory(JobRequest::class, 2)->create();

        $usersJobRequest= factory(JobRequest::class)->create(['title' => 'UsersLogged In', 'user_id' => $user->id]);

        $requestCreatedMoreThan30DaysAgo = factory(JobRequest::class)->create([
            'title' => 'More than 30 Days',
            'updated_at' => Carbon::today()->subDays(31)
        ]);

        $response = $this->hitListJobRequestEndpoint();

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

    /** @test */
    function a_user_can_filter_requests_by_service()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $service = factory(Service::class)->create();

        $requestsToBeSeen = factory(JobRequest::class, 2)->create(['service_id' => $service->id]);

        $requestsTobeFiltered= factory(JobRequest::class)->create(['title' => 'Job to be filtered']);

        $response = $this->hitListJobRequestEndpoint("?service={$service->id}");

        $response->assertStatus(200);

        $response->assertJson(fractal($requestsToBeSeen, new JobRequestTransformer())
            ->parseIncludes('user')->toArray());

        $response->assertJsonMissing([
            'id' => $requestsTobeFiltered->id,
            'title' => $requestsTobeFiltered->title,
        ]);
    }

    /** @test */
    function a_user_can_filter_requests_by_region()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $requestsToBeSeen = factory(JobRequest::class, 2)->create(['city' => 'Berlin']);

        $requestsTobeFiltered= factory(JobRequest::class)->create([
            'title' => 'Job to be filtered',
            'city' => 'Hamburg'
        ]);

        $response = $this->hitListJobRequestEndpoint("?region={$requestsToBeSeen[0]->city}");

        $response->assertStatus(200);

        $response->assertJson(fractal($requestsToBeSeen, new JobRequestTransformer())
            ->parseIncludes('user')->toArray());

        $response->assertJsonMissing([
            'id' => $requestsTobeFiltered->id,
            'title' => $requestsTobeFiltered->title,
        ]);
    }

    /** @test */
    function a_guest_cannot_see_all_job_requests_but_his_own_requests()
    {
        $response = $this->hitListJobRequestEndpoint();

        $response->assertStatus(401);
    }
}
