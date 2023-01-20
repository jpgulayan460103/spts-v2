<?php

namespace Database\Seeders;

use App\Models\GradingScale;
use Illuminate\Database\Seeder;

class GradingScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grading_scales = [
            ['transmuted_grade' => 90, 'descriptor' => "Outstanding", 'remarks' => "Passed"],
            ['transmuted_grade' => 85, 'descriptor' => "Very Satisfactory", 'remarks' => "Passed"],
            ['transmuted_grade' => 80, 'descriptor' => "Satisfactory", 'remarks' => "Passed"],
            ['transmuted_grade' => 75, 'descriptor' => "Fairly Satisfactory", 'remarks' => "Passed"],
            ['transmuted_grade' => 0, 'descriptor' => "Did Not Meet Expectations", 'remarks' => "Failed"],
        ];
        foreach ($grading_scales as $grading_scale) {
            $created_grading_scale = GradingScale::create($grading_scale);
            echo "\e[0;31m Created Grade Scale: \e[0m";
            echo "\e[0;34m Grade:\e[0m $created_grading_scale->grade ";
            echo "\e[0;34m Transmuted Grade:\e[0m $created_grading_scale->grading_scale";
            echo "\n";
        }
    }
}
