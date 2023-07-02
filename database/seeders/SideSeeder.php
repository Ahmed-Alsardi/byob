<?php

namespace Database\Seeders;

use App\Models\Side;
use Database\Seeders\helper\DisableForeignKeys;
use Database\Seeders\helper\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SideSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncateTable("sides");
        $sideTypes = ['tomato', 'onion', 'lettuce', 'ketchup', 'garlic', 'mayo'];
        foreach ($sideTypes as $side) {
            Side::factory()->create([
                'name' => $side,
            ]);
        }
        $this->enableForeignKeys();
    }
}
