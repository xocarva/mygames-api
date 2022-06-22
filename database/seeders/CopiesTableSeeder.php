<?php

namespace Database\Seeders;

use App\Models\Copy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CopiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Copy::factory()->count(2)->create(['user_id' => 1, 'platform_id' => 1]);
        Copy::factory()->count(2)->create(['user_id' => 1, 'platform_id' => 2]);
        Copy::factory()->count(2)->create(['user_id' => 2, 'platform_id' => 3]);
        Copy::factory()->count(4)->create(['user_id' => 2, 'platform_id' => 1]);
        Copy::factory()->count(3)->create(['user_id' => 3, 'platform_id' => 3]);
    }
}
