<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cant_see_index_page()
    {

        $this->post(route('tweets.index'))->assertRedirect('/login');
    }

    /** @test */

    public function loged_in_user_can_see_index_page()
    {

        $this->login()
            ->get(route('tweets.index'))
            ->assertViewIs('tweets.index');

    }

    /** @test */

    public function loged_in_user_can_see_create_page()
    {

        $this->login()
            ->get(route('tweets.create'))
            ->assertViewIs('tweets.create');

    }


    /** @test */
    public function user_can_create_twitt()
    {

        $user = factory('App\User')->create();
        $tweet = factory('App\Tweet')->make();
        $this->login($user)
            ->post(route('tweets.store'), $user->addTweet($tweet->toArray())->toArray());
        $this->assertDatabaseHas('tweets', $tweet->toArray());


    }

    /** @test */
    public function users_can_see_edit_page()
    {

        $user = factory('App\User')->create();
        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        $this->login($user)
            ->get(route('tweets.edit', $tweet->id))
            ->assertViewIs('tweets.edit');

    }

    /** @test */
    public function users_can_edit_tweet()
    {

        $user = factory('App\User')->create();
        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        $this->login($user)
            ->patch(route('tweets.update', $tweet->id), [
                'body' => 'new body',
                'title' => 'new title'
            ]);

        $this->assertDatabaseMissing('tweets', $tweet->toArray());

        $this->login($user)
            ->patch(route('tweets.update', $tweet->id), [
                'body' => 'new body 2',

            ]);

        $this->assertDatabaseMissing('tweets', $tweet->toArray());

        $this->login($user)
            ->patch(route('tweets.update', $tweet->id), [

                'title' => 'new title 2 '
            ]);

        $this->assertDatabaseMissing('tweets', $tweet->toArray());

    }


    /** @test */

    public function user_can_delete_tweet(){
        $user = factory('App\User')->create();
        $tweet = factory('App\Tweet')->create(['user_id' => $user->id]);
        $this->login($user)
            ->delete(route('tweets.destroy', $tweet->id));
        $this->assertDatabaseMissing('tweets', $tweet->toArray());

    }


    /** @test */
    public function test_for_upload_file()
    {


        Storage::fake('files');
        $file = UploadedFile::fake()->create('text.txt');
        $this->json('POST', route('tweet.upload'), [
            'text' => $file,
        ]);
        Storage::disk('files')->assertExists($file->hashName());

    }
}
