<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class OwnlistController extends Controller
{
    /**
     * Quickly put story in user's list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Story $story)
    {
        $request->user()->addStory($story);

        return redirect()->back();
    }

    /**
     * Adds or change reading status of story in user's list
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listAs(Request $request, Story $story)
    {
        $validated = $request->validate([
            'my_status' => 'required',
        //     'my_status' => 'nullable|in:reading,complete,on-hold,dropped,plan to read'
        ]);

        // $request->user()->listAs($story, $validated['my_status']);
        $request->user()->listAs($story, $validated['my_status']);

        return redirect()->back();
    }

    /**
     * Update reader status, rating and progress for that story.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'my_status' => 'required',
            // 'my_status' => 'nullable|in:reading,complete,on-hold,dropped,plan to read'
            'rating' => '',
            'favorited' => '',
            'progress' => '',
        ]);

        // dd($request->all());

        // $request->user()->listAs($story, $validated['my_status']);
        $request->user()->updateListed($story, $validated);

        return redirect()->back();
    }

    public function remove(Request $request, Story $story)
    {
        $request->user()->stories()->detach($story->id);

        return redirect()->back();
    }
}
