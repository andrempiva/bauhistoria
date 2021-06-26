<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;

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
        // $author = (new Author())->firstOrCreateWithSlug($validated['author']);
        // $story = $author->stories()->create($validated);

        $author = Author::firstOrCreateWithSlug($validated['author']);
        // it's now in the model in the setAuthorAttribute function

        // $story = Story::create($validated);
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
    public function show(Story $story)
    {
        // $story = Story::whereSlug($slug)->firstOrFail();

        if (Auth::check()) {
            // $story = Story::whereSlug($slug)->with('readers', function($query){
            $story->load(['readers' => function($query){
                // Auth::id()
                $query->where('user_id', Auth::id());
            }]);
            // })->first();
        }

        // if ($story === null) {
        //     $story = Story::whereSlug($slug)->first();
        // }

        // if ($story === null) { throw new ModelNotFoundException(); }



        $tags = Tag::withCount(['stories'])->get();

        // LOL
        // $story = Auth::check() ? Story::whereSlug($slug)->with('readers', function($query){ $query->where('user_id', Auth::id()); })->first() : Story::whereSlug($slug)->first();

        return view('story.show', compact('story', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        if ($story->locked_at && !auth()->user()->is_admin) {
			return back()->with('status', [ 'type' => 'error', 'msg' => 'A edição dessa história foi trancada.' ]);
        }
        // $story = Story::whereSlug($slug)->with('tags')->first();
        // $story->loadMissing('tags');

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
        if ($story->locked_at && !auth()->user()->is_admin) {
			return redirect()->route('story.show', $story)
                ->with('status', [ 'type' => 'error', 'msg' => 'A edição dessa história foi trancada.' ]);
        }

        $validated = $request->validate([
            'title' => 'bail|required|string|unique:stories,title,'.$story->id,
            'author' => 'required|string',
            'full_title' => 'sometimes|nullable|string',
            'fandom' => 'required|string',
            'type' => 'required|string',
            'my_status' => 'nullable|in:complete,incomplete',
            'fandom' => [
                'nullable',
                Rule::in(fandomList())
            ],
            'link' => 'sometimes|nullable|string',
            'is_locked' => 'sometimes',
        ]);

        // logar atividade

        if (auth()->user()->is_admin) {
            // Lock Unlock mechanism
            if ($request->has('is_locked') != $story->locked_at) {
                $story->locked_at = $story->locked_at ? null : now();
                $story->save();
            }
        }

        $story->update($validated);

        $returnRoute = route('story.show', $story->slug);
        if ($request->routeIs('admin.stories.update')) {
            $returnRoute = route('admin.stories.index');
            // return redirect()->route('admin.stories.index')->with('status', successMsg('História atualizada com sucesso.'));
        }
        return redirect($returnRoute)->with('status', successMsg('História atualizada com sucesso.'));
        // return redirect()->route('story.show', $story->slug)->with('status', successMsg('História atualizada com sucesso.'));
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

    public function topStories()
    {
        $stories = Story::topStories();
        $user = null;
        if (auth()->check()) {
            // $user = auth()->user()->load('stories');
            $user = User::whereId(auth()->id())->with('stories')->first();
            // dd($user);
            //DB::whereId(auth()->id())->with('stories')->get()[0];
        }

        return view('story.top-stories')->with(compact('stories', 'user'));
        // // from stories with more than 5 rates
        // $topStories = DB::table('stories')
        //         ->join('listed', function ($join) {
        //             $join->on('stories.id', '=', 'listed.story_id')
        //                 ->where('rating', '!=', null);
        //                 // ->whereCount('rating', '>', 10);
        //         })
        //         // ->toSql();
        //         ->selectRaw('avg(rating) as avg_rating')->groupBy('id')
        //         ->orderByDesc('avg_rating')
        //         // ->havingRaw('COUNT(rating) > ?', [10])
        //         ->get();
        //         // ->average('listed.rating')->orderBy('avg_rating', 'desc')->limit(10);
        //         // $query->select('story_id')
        //         //     ->from('listed')
        //         //     ->whereColumn('stories.id', 'listed.story_id')
        //         //     ->groupBy('story_id')
        //         //     ->havingCount('rating', '>', 9)
        //     // })
        //     // ->select()
        // // whereHas('readers', function (Builder $query) {
        // //     $query->whereNotNull('rating');
        // // })
        // // ->join('listed.story_id', 'stories.id')

        // // selectRaw('avg(su.rating) as avg_rating')->from('listed as su')->orderBy('avg_rating', 'desc')->limit(10)->get();
        // // get average, order_by average, limit 10

        // // return response()->json($topStories);

        // $topStories = Story::topStories();

        // return view('story.top-stories')->with(compact('topStories'));
    }

    public function assignTag(Request $request, Story $story)
    {
        // $story = Story::whereSlug($slug)->with('tags')->first();
        $tagId = Tag::find($request->get('tag'))->id;

        if ($story->tags->contains(
                function($tag) use ($tagId) {
                    return $tag->id == $tagId;
                }
            )
        ) {
            return back()->with("status", [ 'type' => 'warning', 'msg' => 'Essa história já tem essa tag' ]);
        };

        $story->tags()->attach($tagId);

        return back()->with("status", [ 'type' => 'success', 'msg' => 'Tag adicionada à história']);
    }

    public function rateUp(Request $request, Story $story, Tag $tag)
    {
        // $validated = $request->validate([
        //     'tag'
        // ]);
        $association = $story->tags()->whereTagId($tag->id)->first();

        if ($association === null) {
            return back()->with([ 'type' => 'warning', 'msg' => 'Essa história não tem essa tag' ]);
        }

        $score = $association->tagged->tagged_score;
        $story->tags()->updateExistingPivot($tag->id, ['tagged_score' => $score + 1]);


        // $association->tagged_score = $association->tagged_score + 1;
        // $association->save();

        return back()->with([ 'type' => 'sucesso', 'msg' => 'Deu joínha!' ]);
    }

    public function rateDown(Request $request, Story $story, Tag $tag)
    {
        $association = $story->tags()->whereTagId($tag->id)->first();

        if ($association === null) {
            return back()->with([ 'type' => 'warning', 'msg' => 'Essa história não tem essa tag' ]);
        }

        $score = $association->tagged->tagged_score;
        $story->tags()->updateExistingPivot($tag->id, ['tagged_score' => $score - 1]);

        // $association->tagged->tagged_score = $association->tagged_score - 1;
        // $association->save();
        return back()->with([ 'type' => 'sucesso', 'msg' => 'Deu joínha!' ]);
    }
}
