<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TransmutedGradeSeeder::class);
        $this->call(LibrarySeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(GradingSystemSeeder::class);
    }
}
