<?php

namespace Tests\Feature;

use App\JobRequest;
use App\User;
use Tests\TestCase;

class CreateJobRequestTest extends TestCase
{
    /**
     * A data provider for required fields for creating job request.
     *
     * @return array
     */
    public function requiredFields()
    {
        return [
            ['title'],
            ['description'],
            ['zip'],
            ['city'],
            ['deadline'],
            ['service_id'],
        ];
    }

    /**
     * Sends post request to create job request.
     *
     * @param $jobRequestData
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function hitCreateJobRequestEndpoint($jobRequestData)
    {
        $response = $this->post(route('createJobRequest'), $jobRequestData);
        return $response;
    }

    /** @test */
    function a_user_can_create_a_job_request()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $jobRequestData = factory(JobRequest::class)->make(['user_id' => null])->toArray();

        $response = $this->hitCreateJobRequestEndpoint($jobRequestData);

        $response->assertStatus(201);

        $jobRequestData['user_id'] = $user->id;

        $this->assertDatabaseHas('job_requests', $jobRequestData);

        $response->assertJson(['data' => array_except($jobRequestData, ['user_id', 'service_id'])]);
    }

    /** @test */
    function a_guest_cannot_create_a_job_request()
    {
        $jobRequestData = factory(JobRequest::class)->make()->toArray();

        $response = $this->hitCreateJobRequestEndpoint($jobRequestData);

        $response->assertStatus(401);
    }

    /**
     * @test
     *
     * @dataProvider requiredFields
     *
     * @param $field
     */
    function a_user_cannot_create_a_job_request_without_required_fields($field)
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $jobRequestData = factory(JobRequest::class)->make(['user_id' => null])->toArray();

        unset($jobRequestData[$field]);

        $response = $this->hitCreateJobRequestEndpoint($jobRequestData);

        $this->assertValidationError($response, $field);
    }
}
