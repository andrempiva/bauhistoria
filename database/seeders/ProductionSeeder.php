<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::first()) {
            User::create([
                'name' => 'Admin Padrão',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('secret'),
                'is_admin' => true,
            ]);
        }
    }
}
