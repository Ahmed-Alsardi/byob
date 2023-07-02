<?php

namespace Database\Seeders;

use App\Models\Burger;
use Database\Seeders\helper\DisableForeignKeys;
use Database\Seeders\helper\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BurgerSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncateTable("burgers");
        Burger::factory()->count(10)->create();
        $this->enableForeignKeys();
    }
}
