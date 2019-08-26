<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AnketaTest extends TestCase
{
    public function testGetAccessPage()
    {
        $response = $this->get('/anketa-a');

        $response->assertStatus(200);
    }

    public function testGetNotFoundPage()
    {
        $response = $this->get('/anketa-c');

        $response->assertStatus(404);
    }

    public function testPostRedirect()
    {
        Session::start();

        $response = $this->post(
            route('anketa', ['litera' => 'a']),
            ['_token' => csrf_token()]
        );

        $this->assertEquals(302, $response->getStatusCode());
        $response->assertRedirect(route('home'));
    }
}
