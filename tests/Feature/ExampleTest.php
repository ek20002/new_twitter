<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cant_see_twitts()
    {

        $this->post(route('tweets.index'))->assertRedirect('/login');
    }

    /** @test */

    public function users_can_see_twitts()
    {

        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $response = $this->get(route('tweets.index'));
        $response->assertStatus(200);

    }


    /** @test */
    public function user_can_create_twitt()
    {

        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $this->post(route('tweets.store'), [
            'title' => 'new title',
            'body' => 'new body'
        ]);
        $this->assertDatabaseHas('tweets', [
            'title' => 'new title',
            'body' => 'new body'
        ]);

    }
}
