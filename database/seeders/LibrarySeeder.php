<?php

namespace Database\Seeders;

use App\Models\Library;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
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
                'name' => "First Quarter",
                'library_type' => "quarters",
            ],
            [
                'name' => "Second Quarter",
                'library_type' => "quarters",
            ],
            [
                'name' => "Third Quarter",
                'library_type' => "quarters",
            ],
            [
                'name' => "Fourth Quarter",
                'library_type' => "quarters",
            ],
            [
                'name' => "First Semester",
                'library_type' => "semesters",
            ],
            [
                'name' => "Second Semester",
                'library_type' => "semesters",
            ],
            [
                'name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'library_type' => "tracks",
            ],
            [
                'name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'library_type' => "tracks",
            ],
            [
                'name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'library_type' => "tracks",
            ],
            [
                'name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'library_type' => "tracks",
            ],
            [
                'name' => "CORE SUBJECT",
                'library_type' => "subject_categories",
            ],
            [
                'name' => "APPLIED SUBJECT",
                'library_type' => "subject_categories",
            ],
            [
                'name' => "SPECIALIZED SUBJECT",
                'library_type' => "subject_categories",
            ],
            [
                'name' => "11",
                'library_type' => "grade_levels",
            ],
            [
                'name' => "12",
                'library_type' => "grade_levels",
            ],
            [
                'name' => "Male",
                'library_type' => "genders",
            ],
            [
                'name' => "Female",
                'library_type' => "genders",
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
