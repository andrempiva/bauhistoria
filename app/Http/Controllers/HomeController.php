<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $stories = Story::all();

        return view('home')->with(compact('stories'));
    }
}
