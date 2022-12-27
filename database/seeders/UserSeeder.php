<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => 'admin',
            ]
        ];
        foreach ($users as $user) {
            $created_user = User::create($user);
            $created_user->assignRole('admin');
            echo "\e[0;31m Created user: \e[0m";
            echo "\e[0;34m username:\e[0m $created_user->username ";
            echo "\e[0;34m password:\e[0m admin ";
            echo "\n";
        }
    }
}
