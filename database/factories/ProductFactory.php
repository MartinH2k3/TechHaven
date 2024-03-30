<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(), // Generates a UUID for the product ID
            'image_id_long' => "BobTheExample", // image ID
            'product_name' => fake()->words(5, true), // Generates a random product name
            'product_description' => fake()->sentence(20), // Generates a random sentence as product description
            'operating_system' => fake()->randomElement(['Android', 'iOS', 'Linux', 'Windows', 'Mac', 'Iné']), // Randomly chooses an OS
            'category' => fake()->randomElement(['Mobily', 'Tablety', 'Notebooky', 'Herné Konzoly']), // Randomly chooses a category
            'ram' => fake()->randomElement([4, 8, 16, 32]), // Assigns random RAM value
            'display_size' => fake()->numberBetween(5, 15), // Random display size between 5 and 15
            'price' => fake()->randomFloat(2, 100, 2000), // Generates a random price between 100 and 2000
        ];
    }
}
