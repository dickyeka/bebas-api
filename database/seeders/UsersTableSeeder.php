<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //clear table
        User::create([
            'name' => 'username',
            'email' => 'user@email.com',
            'password' => bcrypt('userpass'),
        ]);
    }
}
