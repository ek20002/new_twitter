<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //

    public function store()
    {


        Storage::disk('files')->put('', request()->file('text'));

    }
}
