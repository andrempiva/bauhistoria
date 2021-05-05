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
            'title' => $this->faker->sentence(5),
            'author' => $this->faker->word(),
            'story_status' => storyStatusList()[random_int(0,2)],
            'fandom' => fandomList()[random_int(0, count(fandomList())-1)],
        ];
    }
}
