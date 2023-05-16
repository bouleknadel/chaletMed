<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'numero_devilla' => '123',
            'numero_de_telephone' => '0123456789',
            'numero_de_telephone2' => '9876543210',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminadmin'),
            'role' => 'admin',
        ]);
    }
}
