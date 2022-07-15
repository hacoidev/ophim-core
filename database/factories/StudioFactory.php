<?php

namespace Ophim\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ophim\Core\Models\Studio;
use Illuminate\Support\Str;

class StudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Studio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->name,
            'slug' => Str::slug($name),
        ];
    }
}
