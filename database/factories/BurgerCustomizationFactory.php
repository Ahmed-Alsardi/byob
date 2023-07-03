<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BurgerCustomization>
 */
class BurgerCustomizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ["bread", "meat", "side"];
        return [
            "category" => $categories[array_rand($categories)],
            "name" => $this->faker->word,
        ];
    }
}
