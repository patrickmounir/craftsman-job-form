<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Custom assertion for validation error.
     *
     * @param TestResponse $response
     * @param string $field
     */
    protected function assertValidationError(TestResponse $response, string $field)
    {
        // The response should be 422
        $response->assertStatus(422);

        // The returned json should contain the validation error on the given field
        $errorMessages = $response->decodeResponseJson()['error']['message'];

        $this->assertArrayHasKey($field, $errorMessages);
    }
}
