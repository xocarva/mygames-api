<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenresTableSeeder::class);
        $this->call(PlatformsTableSeeder::class);
        $this->call(StudiosTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CopiesTableSeeder::class);
    }
}
