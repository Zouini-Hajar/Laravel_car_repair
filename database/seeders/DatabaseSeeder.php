<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Mechanic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(20)->create();
        Client::factory(10)->create();
        Mechanic::factory(10)->create();
    }
}
