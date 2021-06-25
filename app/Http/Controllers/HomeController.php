<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        // $stories = Story::all();
        $stories = Story::query()->take(10)->get();
        $user = null;
        if (auth()->check()) {
            // $user = auth()->user()->load('stories');
            $user = User::whereId(auth()->id())->with('stories')->first();
            // dd($user);
            //DB::whereId(auth()->id())->with('stories')->get()[0];
        }

        return view('welcome')->with(compact('stories', 'user'));
        // return view('story.index')->with(compact('stories', 'user'));
    }
}
