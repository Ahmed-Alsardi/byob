<?php

namespace Database\Seeders;

use App\Models\BurgerCustomization;
use Database\Seeders\helper\DisableForeignKeys;
use Database\Seeders\helper\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BurgerCustomizationSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncateTable("burger_customizations");
        $meats = ["meat", "chicken"];
        $breads = ["white", "brown"];
        $sides = ["tomato", "onion", "lettuce", "ketchup", "garlic", "mayo"];
        $this->addCustomization("meat", $meats);
        $this->addCustomization("bread", $breads);
        $this->addCustomization("side", $sides);
        $this->enableForeignKeys();
    }

    private function addCustomization(string $category, array $names): void
    {
        foreach ($names as $name) {
            BurgerCustomization::factory()->create([
                "category" => $category,
                "name" => $name,
            ]);
        }
    }
}
