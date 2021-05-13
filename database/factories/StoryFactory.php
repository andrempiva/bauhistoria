<?php

namespace Database\Factories;

use App\Models\Story;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Story::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(random_int(1,4)),
            'story_status' => storyStatusList()[random_int(0,count(storyStatusList())-1)],
            'fandom' => fandomList()[random_int(0, count(fandomList())-1)],
        ];
    }
}
