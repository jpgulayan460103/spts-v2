<?php

namespace Database\Seeders;

use App\Models\Library;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Oral Communications',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Komunikasyon sa Pananaliksik sa Wika at Kulturang Pilipino',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Introduction to the Philosophy of the Human Person',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'General Mathematics',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Earth and Life Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Empowerment Technologies (E-Tech)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Food and Beverages 1 (NCII)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Reading and Writing Skills',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Pagbasa at Pagsusuri ng Iba’t-Ibang Teksto Tungo sa Pananaliksik',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Statistics and Probability',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Personal Development',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 2',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Food and Beverages 2 (NCII)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Housekeeping Services 1 (NCII)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => '21st Century Literature from the Philippines and the World',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Contemporary Philippines Arts from the Regions',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 3',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 2',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Pagsulat sa Filipino sa Piling Larangan',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Entrepreneurship',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Housekeeping Services 2 (NCII)',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Front Office Services 1 (NCII)',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Tourism 1',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Understanding Culture, Society and Politics',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Media and Information Literacy',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 4',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'English for Academics and Professional Purposes',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Inquiries, Investigations and Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Front Office Services 2 (NCII)',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Tourism 2',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Home Economics Strand",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Work Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Oral Communications',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Komunikasyon sa Pananaliksik sa Wika at Kulturang Pilipino',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Introduction to the Philosophy of the Human Person',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'General Mathematics',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Earth and Life Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Empowerment Technologies (E-Tech)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Reading and Writing Skills',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Pagbasa at Pagsusuri ng Iba’t-Ibang Teksto Tungo sa Pananaliksik',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Statistics and Probability',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Personal Development',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 2',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 2',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 3',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => '21st Century Literature from the Philippines and the World',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Contemporary Philippines Arts from the Regions',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 3',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 2',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Pagsulat sa Filipino sa Piling Larangan',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Entrepreneurship',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 4',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 5',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 6',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Understanding Culture, Society and Politics',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Media and Information Literacy',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 4',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'English for Academics and Professional Purposes',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Inquiries, Investigations and Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 7',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Computer System Servicing 8',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "TECHNICAL VOCATIONAL TRACK – Information and Communications Technology",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Work Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Oral Communications',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Komunikasyon sa Pananaliksik sa Wika at Kulturang Pilipino',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Introduction to the Philosophy of the Human Person',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'General Mathematics',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Earth and Life Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Empowerment Technologies (E-Tech)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Humanities 1 – Introduction to World Religions and Belief Systems',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Reading and Writing Skills',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Pagbasa at Pagsusuri ng Iba’t-Ibang Teksto Tungo sa Pananaliksik',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Statistics and Probability',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Personal Development',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 2',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Humanities 2 – Creative Writing',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Organization Management',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => '21st Century Literature from the Philippines and the World',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Contemporary Philippines Arts from the Regions',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 3',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 2',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Pagsulat sa Filipino sa Piling Larangan',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Entrepreneurship',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Social Science 1 – Philippine Politics and Governance',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Applied Economics',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Understanding Culture, Society and Politics',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Media and Information Literacy',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 4',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'English for Academics and Professional Purposes',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Inquiries, Investigations and Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Pre-Calculus',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Principles of Marketing',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – General Academic Strand (GAS)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Work Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Oral Communications',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Komunikasyon sa Pananaliksik sa Wika at Kulturang Pilipino',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Introduction to the Philosophy of the Human Person',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'General Mathematics',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Earth and Life Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Empowerment Technologies (E-Tech)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Business Mathematics',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Reading and Writing Skills',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Pagbasa at Pagsusuri ng Iba’t-Ibang Teksto Tungo sa Pananaliksik',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Statistics and Probability',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Science (Lecture and Laboratory)',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Personal Development',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 2',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Fundamentals of Accountancy, Business and Management 1',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Organization and Management',
                'grade_level_name' => 11
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => '21st Century Literature from the Philippines and the World',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Contemporary Philippines Arts from the Regions',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 3',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Practical Research 2',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Pagsulat sa Filipino sa Piling Larangan',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Entrepreneurship',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Fundamentals of Accountancy, Business and Management 2',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "First Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Applied Economics',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Understanding Culture, Society and Politics',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Media and Information Literacy',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "CORE SUBJECT",
                'subject_description' => 'Physical Education and Health 4',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'English for Academics and Professional Purposes',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "APPLIED SUBJECT",
                'subject_description' => 'Inquiries, Investigations and Immersion',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Business Finance',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Principles of Marketing',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Business Ethics and Social Responsibility',
                'grade_level_name' => 12
            ],
            [
                'track_name' => "ACADEMIC TRACK – Accountancy, Business and Management (ABM)",
                'semester_name' => "Second Semester",
                'subject_category_name' => "SPECIALIZED SUBJECT",
                'subject_description' => 'Work Immersion',
                'grade_level_name' => 12
            ],
        ];
        foreach ($subjects as $subject) {
            $track = Library::where("name", $subject['track_name'])->where("library_type", "tracks")->first();
            $semester = Library::where("name", $subject['semester_name'])->where("library_type", "semesters")->first();
            $subject_category = Library::where("name", $subject['subject_category_name'])->where("library_type", "subject_categories")->first();
            $grade_level = Library::where("name", $subject['grade_level_name'])->where("library_type", "grade_levels")->first();
            $subject['track_id'] = $track->id;
            $subject['semester_id'] = $semester->id;
            $subject['subject_category_id'] = $subject_category->id;
            $subject['grade_level_id'] = $grade_level->id;

            unset($subject['track_name']);
            unset($subject['semester_name']);
            unset($subject['subject_category_name']);
            unset($subject['grade_level_name']);
            
            $created_subject = Subject::create($subject);
            echo "\e[0;31m Created track: \e[0m";
            echo "\e[0;34m subject description:\e[0m $created_subject->subject_description ";
            echo "\n";
        }
    }
}
