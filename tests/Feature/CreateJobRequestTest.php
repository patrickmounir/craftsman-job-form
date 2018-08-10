<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class CreateJobRequestTest extends TestCase
{
    /** @test */
    function a_user_can_create_a_job_request()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $jobRequestData = factory(JobRequest::class)->make(['user_id' => null])->toArray();

        $response = $this->post(route('createJobRequest'), $jobRequestData);

        $response->assertStatus(200);

        $jobRequestData['user_id'] = $user->id;

        $this->assertDatabaseHas('job_requests', $jobRequestData);

        $response->assertJson(['data' => array_except($jobRequestData, ['user_id', 'service_id'])]);
    }
}
