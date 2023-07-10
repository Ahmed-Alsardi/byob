<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\helper\DisableForeignKeys;
use Database\Seeders\helper\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     */
    #TODO please add password for system users
    public function run(): void
    {
     $this->disableForeignKeys();
     $this->truncateTable('users');
     User::factory()->count(10)->create();
     $this->enableForeignKeys();
    }
}
