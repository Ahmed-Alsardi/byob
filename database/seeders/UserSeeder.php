<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\helper\DisableForeignKeys;
use Database\Seeders\helper\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $this->disableForeignKeys();
     $this->truncateTable('users');
     User::factory()->count(10)->create();
     $this->enableForeignKeys();
    }
}
