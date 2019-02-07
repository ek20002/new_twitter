<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login($user = null)
    {
        if ($user == null) {
            return $this->actingAs(factory('App\User')->create());
        } else {
            return $this->actingAs($user);

        }

    }


    protected  function create_file(){

         Storage::fake('files');
         return UploadedFile::fake()->create('text.txt');

    }
}
