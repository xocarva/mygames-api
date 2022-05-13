<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => Hash::make('password'),
            'admin'    => true,
        ]);

        // $user->createToken('JohnDoe')->plainTextToken;

        User::factory()->count(5)->create();
    }
}
