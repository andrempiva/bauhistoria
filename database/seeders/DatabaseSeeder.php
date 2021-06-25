<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        if (!Author::first()) {
            Author::factory()
                ->count(2)
                ->has(Story::factory()->count(3), 'stories')
                ->create();
        }

        Author::first()->stories()->create([
            'title' => 'A Cloudy Path',
            'author' => 'LacksCreativity',
        ]);

        if (!User::first()) {
            $user = User::create([
                'name' => 'Andre',
                'email' => 'andrempiva@gmail.com',
                'password' => Hash::make('secret')
            ]);
            $user->stories()->attach([1,2,3]);
            $user->is_admin = true;
            $user->save();
        }
    }
}
