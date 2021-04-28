<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Story::create([
            'title' => 'A Cloudy Path',
            'author' => 'LacksCreativity',
            'fandom' => 'worm',
        ]);

    }
}
