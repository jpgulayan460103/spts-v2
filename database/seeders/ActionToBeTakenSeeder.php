<?php

namespace Database\Seeders;

use App\Models\Library;
use Illuminate\Database\Seeder;

class ActionToBeTakenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $libraries = [
            [
                'name' => "One-on-One Consultation",
                'library_type' => "action_options",
            ],
            [
                'name' => "Remedial Classes",
                'library_type' => "action_options",
            ],
            [
                'name' => "Parent Conference",
                'library_type' => "action_options",
            ],
            [
                'name' => "Reinforcement",
                'library_type' => "action_options",
            ],
        ];
        foreach ($libraries as $library) {
            $created_library = Library::create($library);
            echo "\e[0;31m Library: \e[0m";
            echo "\e[0;34m Name:\e[0m $created_library->name ";
            echo "\e[0;34m Library Type:\e[0m $created_library->library_type";
            echo "\n";
        }
    }
}
