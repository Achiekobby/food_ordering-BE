<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::title(fake()->name().' foods');
        $slug = Str::slug($name);

        return [
            'name'=>$name,
            'slug'=>$slug,
            'city'=>fake()->city(),
            'address'=>fake()->address(),
        ];
    }
}
