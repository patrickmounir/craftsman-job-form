<?php

namespace Tests\Feature\JobRequests;

use App\JobRequest;
use App\Transformers\JobRequestTransformer;
use App\User;
use Tests\TestCase;

class ListMyRequestsTest extends TestCase
{
    /**
     * Sends get request to list logged in user requests.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function hitMyRequestEndpoint(): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->get(route('listMyRequests'));
        return $response;
    }

    /** @test */
    function a_user_can_list_hit_own_requests()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $otherRequest = factory(JobRequest::class)->create();

        $usersJobRequest= factory(JobRequest::class, 2)->create(['title' => 'UsersLogged In', 'user_id' => $user->id]);

        $response = $this->hitMyRequestEndpoint();

        $response->assertStatus(200);

        $response->assertJson(fractal($usersJobRequest, new JobRequestTransformer())->toArray());

        $response->assertJsonMissing([
            'id' => $otherRequest->id,
            'title' => $otherRequest->title,
        ]);
    }

    /** @test */
    function a_guest_cannot_list_hit_own_requests()
    {
        $response = $this->hitMyRequestEndpoint();

        $response->assertStatus(401);
    }
}
