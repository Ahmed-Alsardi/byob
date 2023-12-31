<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Helper\UserRole;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BurgerCustomizationSeeder::class,
        ]);
        User::factory()->create([
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => bcrypt("password"),
            "role" => UserRepository::ADMIN,
        ]);
        User::factory()->create([
            "name" => "customer",
            "email" => "t@t.com",
            "password" => bcrypt("password"),
            "role" => UserRepository::CUSTOMER,
        ]);
    }
}
