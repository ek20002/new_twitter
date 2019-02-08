<?php

namespace Tests\Unit;

use App\Tweet;
use App\User;
use Illuminate\Database\QueryException;
use mysql_xdevapi\Exception;
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

    public function test_add_comments_method_of_tweet_model()
    {

        $user = factory('App\User')->create();
        $tweet = factory('App\Tweet')->make();
        $comment = factory('App\Comment')->make();
        $comment['user_id'] = $user->id;
        $user->addTweet($tweet->toArray())->addComment($comment->toArray());
        $this->assertDatabaseHas('comments', $comment->toArray());

    }


    /** @test */

    public function store_request_pass_validation_for_title()
    {

        $this->login()->post(route('tweets.store'), [
            'title' => str_repeat('a', 3),
            'body' => str_repeat('a', 1)
        ])->assertRedirect(route('tweets.index'));


        $this->login()->post(route('tweets.store'), [
            'title' => str_repeat('a', 256),
            'body' => str_repeat('a', 1)
        ])->assertRedirect('/');

        $this->login()->post(route('tweets.store'), [
            'title' => str_repeat('a', 255),
            'body' => str_repeat('a', 1)
        ])->assertRedirect(route('tweets.index'));


    }

    /** @test */

    public function store_request_pass_validation_for_body()
    {
        $this->login()->post(route('tweets.store'), [
            'title' => str_repeat('a', 3),
            'body' => str_repeat('a', 1)
        ])->assertRedirect(route('tweets.index'));

        $this->login()->post(route('tweets.store'), [
            'title' => str_repeat('a', 3),
        ])->assertRedirect('/');


    }

    /** @test */
    public function validation_of_body_of_comment()
    {
        $user = factory('App\User')->create();
        $this->login($user);
        $tweet = $user->addTweet(factory('App\Tweet')->make()->toArray());

        $this->post(route('tweet.comments.store', $tweet->id), [
            'body' => 'a',
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
        $this->assertDatabaseHas('comments', [
            'body' => 'a',
            'user_id' => $user->id,
            'tweet_id' => $tweet->id]);


        $this->post(route('tweet.comments.store', $tweet->id), [
            'body' => '',
            'user_id' => $user->id,
            'tweet_id' => $tweet->id
        ]);
        $this->assertDatabaseMissing('comments', [
            'body' => '',
            'user_id' => $user->id,
            'tweet_id' => $tweet->id]);


    }


    /** @test */

    public function check_fillable_attribute_of_user_model()
    {
        $this->withoutExceptionHandling();
        $user = factory('App\User')->make();
        //dd($user->toArray());
        User::create(array_merge($user->toArray(), [
            'password' => 'secret',

        ]));
        $this->assertDatabaseHas('users', [
            'password' => 'secret',
            'email' => $user->email,
        ]);


    }


    /** @test */

    public function check_fillable_attribute_of_tweet_model()
    {
        $this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $this->expectException(QueryException::class);
        Tweet::create([
            'title' => 'new title',
            'body' => 'body',
            'user_id' => $user->id
        ]);


    }

}
