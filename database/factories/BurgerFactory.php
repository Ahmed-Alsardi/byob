<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Burger>
 */
class BurgerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $breadTypes = ["white", "brown"];
        $meatTypes = ["meat", "chicken"];
//        get random bred and meat
        $bread = $breadTypes[array_rand($breadTypes)];
        $meat = $meatTypes[array_rand($meatTypes)];
        return [
            "bread" => $bread,
            "meat" => $meat,
        ];
    }
}
