<?php

namespace Ophim\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ophim\Core\Models\Episode;
use Illuminate\Support\Str;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = rand(1, 5),
            'slug' => Str::slug('tap-' . $name),
        ];
    }
}
