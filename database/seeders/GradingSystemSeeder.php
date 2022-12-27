<?php

namespace Database\Seeders;

use App\Models\GradingSystem;
use App\Models\Library;
use Illuminate\Database\Seeder;

class GradingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grading_systems = [
            [
                'subject_category_name' => "CORE SUBJECT",
                'name' => 'Written Work',
                'percentage' => 0.25,
            ],
            [
                'subject_category_name' => "CORE SUBJECT",
                'name' => 'Performance Task',
                'percentage' => 0.50,
            ],
            [
                'subject_category_name' => "CORE SUBJECT",
                'name' => 'Quarterly Exam',
                'percentage' => 0.25,
            ],
            [
                'subject_category_name' => "APPLIED SUBJECT",
                'name' => 'Written Work',
                'percentage' => 0.25,
            ],
            [
                'subject_category_name' => "APPLIED SUBJECT",
                'name' => 'Performance Task',
                'percentage' => 0.40,
            ],
            [
                'subject_category_name' => "APPLIED SUBJECT",
                'name' => 'Quarterly Exam',
                'percentage' => 0.35,
            ],
            [
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'name' => 'Written Work',
                'percentage' => 0.20,
            ],
            [
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'name' => 'Performance Task',
                'percentage' => 0.60,
            ],
            [
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'name' => 'Quarterly Exam',
                'percentage' => 0.20,
            ],
        ];
        foreach ($grading_systems as $grading_system) {

            $subject_category = Library::where("name", $grading_system['subject_category_name'])->where("library_type", "subject_categories")->first();

            $grading_system['subject_category_id'] = $subject_category->id;
            
            unset($grading_system['subject_category_name']);

            $created_grading_system = GradingSystem::create($grading_system);
            echo "\e[0;31m Created track: \e[0m";
            echo "\e[0;34m subject_category_id:\e[0m $created_grading_system->subject_category_id ";
            echo "\e[0;34m name:\e[0m $created_grading_system->name ";
            echo "\e[0;34m grading system:\e[0m $created_grading_system->percentage ";
            echo "\n";
        }
    }
}
