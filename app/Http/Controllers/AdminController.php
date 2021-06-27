<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Story;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    // CRUD BLOCK
    public function usersIndex(Request $request)
    {
        switch ($request->get('sort_by')) {
            case 'updated': $sort = 'updated_at'; break;
            case 'alpha': $sort = 'name'; break;
            case 'id': default: $sort = 'id'; break;
        }
        switch ($request->get('order')) {
            case 'desc': $order = 'desc'; break;
            case 'asc': default: $order = 'asc'; break;
        }

        $users = User::orderBy($sort, $order)->get();
        return view('admin.users.index')->with(compact('users'));
    }
    public function usersShow(User $user) { return view('admin.users.edit')->with(compact('user')); }
    public function usersEdit(User $user) { return view('admin.users.edit')->with(compact('user')); }
    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => [
                'sometimes', 'required', 'min:3',
                Rule::unique('users', 'name')->ignore($user->id)
            ],
            'email' => [
                'sometimes', 'required', 'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'password' => 'nullable|confirmed',
        ]);

        if ($request->has('is_banned') != $user->banned_at) {
            $user->banned_at = $user->banned_at ? null : now();
        }
        if ($request->has('is_admin') != $user->is_admin) {
            $user->is_admin = !$user->is_admin;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->update($request->except('password'));

        return redirect()->route('admin.users.index')->with("status", [ 'type' => 'success', 'msg' => 'Atualizado com sucesso' ]);
    }
    public function usersDestroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.users.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    // // // // // // //

    // CRUD BLOCK
    public function storiesIndex(Request $request)
    {
        switch ($request->get('sort_by')) {
            case 'updated': $sort = 'updated_at'; break;
            case 'alpha': $sort = 'title'; break;
            case 'author_id': $sort = 'author_id'; break;
            case 'id': default: $sort = 'id'; break;
        }
        switch ($request->get('order')) {
            case 'desc': $order = 'desc'; break;
            case 'asc': default: $order = 'asc'; break;
        }

        $stories = Story::orderBy($sort, $order)->get();

        return view('admin.stories.index')->with(compact('stories'));
    }
    public function storiesDestroy(Story $story)
    {
        $story->delete();
        return redirect(route('admin.stories.index'))->with("status", [ 'type' => 'success', 'msg' => 'História deletada.' ]);
    }
    // // // // // // //

    // CRUD BLOCK
    public function authorsIndex(Request $request)
    {
        switch ($request->get('sort_by')) {
            case 'updated': $sort = 'updated_at'; break;
            case 'story_qty': $sort = 'stories_count'; break;
            case 'alpha': $sort = 'name'; break;
            case 'id': default: $sort = 'id'; break;
        }
        switch ($request->get('order')) {
            case 'desc': $order = 'desc'; break;
            case 'asc': default: $order = 'asc'; break;
        }
        $authors = Author::withCount('stories')->orderBy($sort, $order)->get();
        return view('admin.authors.index')->with(compact('authors'));
    }
    // public function authorsShow(Author $author) { return view('admin.authors.show')->with(compact('user')); }
    public function authorsEdit(Author $author) {
        return view('admin.authors.edit')->with(compact('author'));
    }
    public function authorsUpdate(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => [
                'sometimes', 'required', 'min:3',
                Rule::unique('authors', 'name')->ignore($author->id)
            ],
        ]);
        $author->update($validated);
        return redirect()->route('admin.authors.index')->with("status", [ 'type' => 'success', 'msg' => 'Autor atualizado com sucesso' ]);
    }
    public function authorsChangeDestroy(Request $request, Author $author)
    {
        $request->validate([
            'new_author' => 'required|string|min:3'
        ]);
        $newAuthor = Author::firstOrCreateWithSlug($request->get('new_author'));
        $author->stories()->update(['author_id' => $newAuthor->id]);
        $author->delete();
        return redirect(route('admin.authors.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    public function authorsDestroy(Author $author)
    {
        $author->stories()->delete();
        $author->delete();
        return redirect(route('admin.authors.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletado.' ]);
    }
    // // // // // // //

    // CRUD BLOCK
    public function tagsIndex(Request $request)
    {
        switch ($request->get('sort_by')) {
            case 'updated': $sort = 'updated_at'; break;
            case 'alpha': $sort = 'name'; break;
            case 'tag_num': $sort = 'stories_count'; break;
            case 'id': default: $sort = 'id'; break;
        }
        switch ($request->get('order')) {
            case 'desc': $order = 'desc'; break;
            case 'asc': default: $order = 'asc'; break;
        }

        $tags = Tag::withCount('stories')->orderBy($sort, $order)->get();
        return view('admin.tags.index')->with(compact('tags'));
    }
    // public function tagsShow(Tag $tag) { return view('admin.tags.show')->with(compact('tag')); }
    public function tagsEdit(Tag $tag) { return view('admin.tags.edit')->with(compact('tag')); }
    public function tagsUpdate(Request $request, Tag $tag)
    {
        $request->validate(['name'=>'required|string|min:3']);
        $tag->update($request->all());
        return redirect()->route('admin.tags.index')->with("status", [ 'type' => 'success', 'msg' => 'Atualizado com sucesso' ]);
    }
    public function tagsDestroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('admin.tags.index'))->with("status", [ 'type' => 'success', 'msg' => 'Deletada.' ]);
    }
    public function tagsRemove(Tag $tag, Story $story)
    {
        $tag->stories()->detach($story->id);
        return redirect(route('admin.tags.edit'))->with("status", [ 'type' => 'success', 'msg' => 'Tag removida da História' ]);
    }
    // // // // // // //

}
