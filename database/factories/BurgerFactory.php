<?php

namespace Database\Factories;

use App\Repository\BurgerCustomizationRepository;
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
        $meats = BurgerCustomizationRepository::getMeats();
        $breads = BurgerCustomizationRepository::getBreads();
        $sides = BurgerCustomizationRepository::getSides();
        $meat = $meats->random();
        $bread = $breads->random();
        foreach (range(1, rand(1, $sides->count())) as $i) {
            $side = $sides->random();
            $sides->forget($side->id);
        }
        return [
            "meat_id" => $meat->id,
            "bread_id" => $bread->id,
            "sides" => json_encode($sides->pluck("id")->toArray()),
        ];
    }
}
