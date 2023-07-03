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
        BurgerCustomization::factory()->count(20)->create();
        $this->enableForeignKeys();
    }
}
