<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

            Author::first()->stories()->create([
                'title' => 'A Cloudy Path',
                'author' => 'LacksCreativity',
            ]);
        }

        if (!User::first()) {
            $user = User::create([
                'name' => 'Andre',
                'email' => 'andrempiva@gmail.com',
                'password' => Hash::make('secret'),
                'is_admin' => true,
            ]);
            $user->stories()->attach([1,2,3]);
            // $user->is_admin = true;
            $user->save();

            User::factory()->count(10)->create();

            for($i=0;$i<20;$i++) {
                $a = User::all()->random();
                for($x=0;$x<3;$x++){
                    $st = Story::all()->random();
                    if ($a->isStoryListed($st->id)) continue;
                    $a->addStory(
                        $st,
                        [
                            'rating'=>random_int(1,10),
                            'my_status'=>collect(listedStatusList())->random(),
                        ]
                    );
                }
            }
        }
    }
}
