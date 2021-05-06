<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::all();
        $user = null;
        if (auth()->check()) {
            // $user = auth()->user()->load('stories');
            $user = User::whereId(auth()->id())->with('stories')->first();
            // dd($user);
            //DB::whereId(auth()->id())->with('stories')->get()[0];
        }

        return view('story.index')->with(compact('stories', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('story.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // look for author (from slug) or create them
        $validated = $request->validate([
            'title' => 'bail|required|string|unique:stories,title',
            'author' => 'required|string',
            'cover' => 'image|max:200',
            'story_status' => 'nullable|in:'.join(',', storyStatusList()),
            'fandom' => 'nullable|in:'.join(',', fandomList()),
            'link' => 'nullable',
        ]);

        // get author from its slug or create them
        $author = (new Author())->firstOrCreateWithSlug($validated['author']);

        $story = $author->stories()->create($validated);

        // TODO log story creation
        // TODO upload and set cover image
        // TODO create story->changeCover function
        //     have it delete previous image (if it had any) and change the cover

        // redirect to story page
        return redirect()->route('story.show', $story)
            ->with('status', successMsg('Story created with success.'));
        // return redirect()->back()->with('status', successMsg('Story created with success.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $story = null;

        if (Auth::check()) {
            $story = Story::whereSlug($slug)->with('readers', function($query){
                $query->where('user_id', Auth::id());
            })->first();
        }

        if ($story === null) {
            $story = Story::whereSlug($slug)->first();
        }

        // LOL
        // $story = Auth::check() ? Story::whereSlug($slug)->with('readers', function($query){ $query->where('user_id', Auth::id()); })->first() : Story::whereSlug($slug)->first();

        return view('story.show', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        $story->load('tags');
        return view('story.edit')->with(['story' => $story]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'bail|required|string|unique:stories,title,'.$story->id,
            'author' => 'required|string',
            'my_status' => 'nullable|in:complete,incomplete',
            'fandom' => [
                'nullable',
                Rule::in(fandomList())
            ],
            'link' => '',
        ]);

        $story->update($validated);

        // logar atividade

        return redirect()->route('home')->with('status', successMsg('Story updated with success.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
    }

    public function topStories() {
        // from stories with more than 5 rates
        $topStories = DB::table('stories')
                ->join('story_user', function ($join) {
                    $join->on('stories.id', '=', 'story_user.story_id')
                        ->where('rating', '!=', null);
                        // ->whereCount('rating', '>', 10);
                })
                // ->toSql();
                ->selectRaw('avg(rating) as avg_rating')->groupBy('id')
                ->orderByDesc('avg_rating')->havingRaw('COUNT(rating) > ?', [10])
                ->get();
                // ->average('story_user.rating')->orderBy('avg_rating', 'desc')->limit(10);
                // $query->select('story_id')
                //     ->from('story_user')
                //     ->whereColumn('stories.id', 'story_user.story_id')
                //     ->groupBy('story_id')
                //     ->havingCount('rating', '>', 9)
            // })
            // ->select()
        // whereHas('readers', function (Builder $query) {
        //     $query->whereNotNull('rating');
        // })
        // ->join('story_user.story_id', 'stories.id')

        // selectRaw('avg(su.rating) as avg_rating')->from('story_user as su')->orderBy('avg_rating', 'desc')->limit(10)->get();
        // get average, order_by average, limit 10

        return response()->json($topStories);

        return view('top-stories')->with(compact($topStories));
    }
}
