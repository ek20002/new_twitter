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
    public function user_can_create_twitt()
    {

        $user=factory('App\User')->create();
        $tweet=factory('App\Tweet')->create();
        $this->login($user)
            ->post(route('tweets.store'),$user->addTweet($tweet->toArray())->toArray());
        $this->assertDatabaseHas('tweets',$tweet->toArray());


    }


    /** @test */

    public function store_request_pass_validation(){

        $this->login()->post(route('tweets.store'),[
           'title'=>str_repeat('a',3),
            'body'=>str_repeat('a',1)
        ])->assertRedirect(route('tweets.index'));


        $this->login()->post(route('tweets.store'),[
            'title'=>str_repeat('a',256),
            'body'=>str_repeat('a',1)
        ])->assertRedirect('/');

        $this->login()->post(route('tweets.store'),[
            'title'=>str_repeat('a',255),
            'body'=>str_repeat('a',1)
        ])->assertRedirect(route('tweets.index'));


        $this->login()->post(route('tweets.store'),[
            'title'=>str_repeat('a',3),
        ])->assertRedirect('/');

        $this->login()->post(route('tweets.store'),[
            'title'=>str_repeat('a',255),
        ])->assertRedirect('/');

        $this->login()->post(route('tweets.store'),[

            'body'=>str_repeat('a',1)
        ])->assertRedirect('/');

    }


    /** @test */
    public function  test_for_upload_file(){

        $file=$this->create_file();
        $this->json('POST', route('tweet.upload'), [
            'text' => $file,
        ]);
        Storage::disk('files')->assertExists($file->hashName());

    }
}
