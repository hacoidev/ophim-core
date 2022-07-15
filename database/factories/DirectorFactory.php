<?php

namespace Ophim\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Ophim\Core\Models\Director;
use Illuminate\Support\Str;

class DirectorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Director::class;

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
