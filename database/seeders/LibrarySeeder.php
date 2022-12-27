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
                'name' => "First Semester",
                'library_type' => "semesters",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "Second Semester",
                'library_type' => "semesters",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "First Quarter",
                'library_type' => "quarters",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "Second Quarter",
                'library_type' => "quarters",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "Third Quarter",
                'library_type' => "quarters",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "Fourth Quarter",
                'library_type' => "quarters",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'library_type' => "tracks",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'library_type' => "tracks",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'library_type' => "tracks",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'library_type' => "tracks",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "CORE SUBJECT",
                'library_type' => "subject_categories",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "APPLIED SUBJECT",
                'library_type' => "subject_categories",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "SPECIALIZED SUBJECT",
                'library_type' => "subject_categories",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "11",
                'library_type' => "grade_levels",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "12",
                'library_type' => "grade_levels",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "Male",
                'library_type' => "genders",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "Female",
                'library_type' => "genders",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "2019-2020",
                'library_type' => "school_years",
                'parent_name' => null,
                'parent_type' => null,
            ],
            [
                'name' => "2020-2021",
                'library_type' => "school_years",
                'parent_name' => null,
                'parent_type' => null,
            ],

        ];
        foreach ($libraries as $library) {
            unset($library['parent_name']);
            unset($library['parent_type']);
            $created_library = Library::create($library);
            echo "\e[0;31m Library: \e[0m";
            echo "\e[0;34m Name:\e[0m $created_library->name ";
            echo "\e[0;34m Library Type:\e[0m $created_library->library_type";
            echo "\n";
        }
    }
}
