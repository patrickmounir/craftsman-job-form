<?php

namespace Tests\Feature\Services;

use App\Service;
use App\Transformers\ServiceTransformer;
use App\User;
use Tests\TestCase;

class ListServicesTest extends TestCase
{
    /**
     * Sends get request to list services in the system.
     *
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function hitListServicesEndpoint(): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->get(route('listServices'));
        return $response;
    }

    /** @test */
    function a_user_can_list_services()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $services = factory(Service::class, 2)->create();

        $response = $this->hitListServicesEndpoint();

        $response->assertStatus(200);

        $response->assertJson(\Fractal::collection($services, new ServiceTransformer())->toArray());
    }

    /** @test */
    function a_guest_cannot_see_a_request()
    {
        $response = $this->hitListServicesEndpoint();

        $response->assertStatus(401);
    }
}
