<?php

namespace Database\Seeders;

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

        if (!Story::find(1)) {
            Story::create([
                'title' => 'A Cloudy Path',
                'author' => 'LacksCreativity',
            ]);
        }

        if (!User::find(1)) {
            User::create([
                'name' => 'Andre',
                'email' => 'lestatv3@gmail.com',
                'password' => Hash::make('lestatv3')
            ]);
        }
    }
}
