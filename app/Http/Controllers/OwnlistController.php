<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class OwnlistController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Story $story)
    {

        // dd($story);
        // $validated = $request->validate([
        //     'status' => 'nullable|in:reading,complete,on-hold,dropped,plan to read'
        // ]);

        // $request->user()->listAs($story, $validated['status']);
        // $request->user()->listAs($story, 'reading');
        $request->user()->addStory($story);

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listAs(Request $request, Story $story)
    {
        // $validated = $request->validate([
        //     'status' => 'nullable|in:reading,complete,on-hold,dropped,plan to read'
        // ]);

        // $request->user()->listAs($story, $validated['status']);
        $request->user()->listAs($story, 'reading');

        return redirect()->back();
    }

    public function remove(Request $request, Story $story)
    {
        $request->user()->stories()->detach($story->id);

        return redirect()->back();
    }
}
