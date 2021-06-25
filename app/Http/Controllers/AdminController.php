<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }


    // CRUD BLOCK
    public function usersIndex()
    {
        $users = User::get();
        return view('admin.users.index')->with(compact('users'));
    }
    public function usersShow(User $user) { return view('admin.users.edit')->with(compact('user')); }
    public function usersEdit(User $user) { return view('admin.users.edit')->with(compact('user')); }
    public function usersUpdate(Request $request, User $user)
    {
        if ($request->has('is_banned') != $user->banned_at) {
            $user->banned_at = $user->banned_at ? null : now();
            $user->save();
        }
        $user->update($request->all());
        return redirect()->route('admin.users.index')->with("status", [ 'type' => 'success', 'msg' => 'Deletado Atualizado com sucesso' ]);
    }
    public function usersDestroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.users.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    // // // // // // //

    // CRUD BLOCK
    public function storiesIndex()
    {
        $stories = Story::get();
        return view('admin.stories.index')->with(compact('stories'));
    }
    public function storiesShow(Story $story) { return view('admin.stories.show')->with(compact('story')); }
    public function storiesEdit(Story $story) { return view('admin.stories.edit')->with(compact('story')); }
    public function storiesUpdate(Request $request, Story $story)
    {
        if ($request->has('is_banned') != $story->banned_at) {
            $story->banned_at = $story->banned_at ? null : now();
            $story->save();
        }
        $story->update($request->all());
        return redirect()->route('admin.stories.index')->with("status", [ 'type' => 'success', 'msg' => 'Deletado Atualizado com sucesso' ]);
    }
    public function storiesDestroy(Story $story)
    {
        $story->delete();
        return redirect(route('admin.stories.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    // // // // // // //

    // CRUD BLOCK
    public function authorsIndex()
    {
        $authors = Author::get();
        return view('admin.authors.index')->with(compact('authors'));
    }
    public function authorsShow(Author $author) { return view('admin.authors.show')->with(compact('user')); }
    public function authorsEdit(Author $author) { return view('admin.authors.edit')->with(compact('user')); }
    public function authorsUpdate(Request $request, Author $author)
    {
        if ($request->has('is_banned') != $author->banned_at) {
            $author->banned_at = $author->banned_at ? null : now();
            $author->save();
        }
        $author->update($request->all());
        return redirect()->route('admin.authors.index')->with("status", [ 'type' => 'success', 'msg' => 'Deletado Atualizado com sucesso' ]);
    }
    public function authorsDestroy(Author $author)
    {
        $author->delete();
        return redirect(route('admin.authors.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    // // // // // // //

    // CRUD BLOCK
    public function tagsIndex()
    {
        $tags = Tag::get();
        return view('admin.tags.index')->with(compact('tags'));
    }
    public function tagsShow(Tag $tag) { return view('admin.tags.show')->with(compact('tag')); }
    public function tagsEdit(Tag $tag) { return view('admin.tags.edit')->with(compact('tag')); }
    public function tagsUpdate(Request $request, Tag $tag)
    {
        if ($request->has('is_banned') != $tag->banned_at) {
            $tag->banned_at = $tag->banned_at ? null : now();
            $tag->save();
        }
        $tag->update($request->all());
        return redirect()->route('admin.tags.index')->with("status", [ 'type' => 'success', 'msg' => 'Deletado Atualizado com sucesso' ]);
    }
    public function tagsDestroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('admin.tags.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    // // // // // // //

}
