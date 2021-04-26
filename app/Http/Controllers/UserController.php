<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * User Profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(User $user) {
        // $userStories = request()->user()->storiesForListing;
        // return view('profile')->with(compact('userStories'));
        // return request()->user()->storiesForListing;

        $userStories = $user->storiesForListing;
        return view('profile')->with(compact('userStories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settingsUpdate(Request $request)
    {
        $userId = $request->user()->id();
        $validatedValues = $request->validate([
            'name' => [
                'sometimes', 'required', 'min:3',
                Rule::unique('users', 'name')->ignore($userId)
            ],
            'email' => [
                'sometimes', 'required', 'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
        ]);

        $request->user()->update($validatedValues);

        return redirect('settings')->with('status', [
            'msg' => 'Profile updated successfully.',
            'type' => 'success',
            ]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = $request->user();

        if (! Auth::attempt([
                'password' => $request->get('old_password'),
                'email' => $user->email,
            ])) {
            throw ValidationException::withMessages([
                'old_password' => __('auth.password'),
            ]);
        }

        $user->update(['password' => $request->get('password')]);

        return redirect('settings')->with(successMsg(__('auth.password_change_success')));
    }
}
