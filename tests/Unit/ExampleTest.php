<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /** @test */

    public function  test_add_comments_method_of_tweet(){

        $user=factory('App\User')->create();
        $tweet=factory('App\Tweet')->create();
        $comment=  $tweet->addComment(factory('App\Comment')->make());


    }
}
