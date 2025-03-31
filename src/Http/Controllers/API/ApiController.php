<?php

namespace Wave\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function posts()
    {
        return \Wave\Models\Post::all();
    }
}
