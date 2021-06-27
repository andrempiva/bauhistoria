<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Story;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()->count(20)->create();
        $stories = Story::all();
        foreach (Tag::all() as $tag) {
            $a=0;
            do {
                $tag->stories()->attach($stories->random());
                $a++;
            } while($a<6);
        }
    }
}
