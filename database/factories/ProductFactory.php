<?php

namespace Database\Factories;

use App\Models\product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = product::class;

    public function definition(): array
    {
        $name = $this->faker->sentence(3);
        $slug = Str::slug($name, '-');

        return [
            'name' => $name,
            'price' => $this->faker->randomNumber(5, true),
            'description' => $this->faker->paragraph(),
            'slug' => $slug
        ];
    }
}
