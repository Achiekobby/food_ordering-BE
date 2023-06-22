<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->word());
        $slug = Str::slug($title);
        $type = ['breakfast','lunch','supper'];
        return [
            'restaurant_id'=>fake()->numberBetween(1,10),
            'title'=> $title,
            'slug'=> $slug,
            'summary'=>fake()->sentence(),
            'type'=>fake()->randomElement($type),
            'price'=>fake()->randomFloat(2, 5, 50)
        ];
    }
}
