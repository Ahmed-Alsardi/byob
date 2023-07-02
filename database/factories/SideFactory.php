<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Side>
 */
class SideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sideTypes = ['tomato', 'onion', 'lettuce', 'ketchup', 'garlic', 'mayo'];
        $side = $sideTypes[array_rand($sideTypes)];
        return [
            'name' => $side,
        ];
    }
}
