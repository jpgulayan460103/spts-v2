<?php

namespace App\Http\Controllers;

use App\Models\ClassRecord;
use App\Models\GradingScale;
use App\Models\TransmutedGrade;
use App\Models\Unit;
use App\Models\UnitAction;
use App\Models\UnitItem;
use App\Models\UnitScore;
use Illuminate\Http\Request;

class ClassRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassRecord  $classRecord
     * @return \Illuminate\Http\Response
     */
    public function show(ClassRecord $classRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassRecord  $classRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassRecord $classRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassRecord  $classRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $class_record = ClassRecord::find($id);
        $class_record->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassRecord  $classRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassRecord $classRecord)
    {
        //
    }

    public function unitItems(Request $request, $id)
    {
        $class_record = ClassRecord::with([
            'subject.subject_category.grading_systems'
        ])->find($id);

        $grading_systems = $class_record->subject->subject_category->grading_systems;
        foreach ($grading_systems as $key => $grading_system) {
            $grading_system->unit_items = UnitItem::where('unit_id', $request->unit_id)->where('grading_system_id', $grading_system->id)->get();
            $grading_system->total_items = UnitItem::where('unit_id', $request->unit_id)->where('grading_system_id', $grading_system->id)->sum('item');
            $grading_system->count = count($grading_system->unit_items);
            if($grading_system->total_items != 0){
                $grading_system->percentage_score = ($grading_system->total_items / $grading_system->total_items) * 100;
                $grading_system->weighted_score = $grading_system->percentage_score * $grading_system->percentage;
            }else{
                $grading_system->percentage_score = 0;
                $grading_system->weighted_score = 0;
            }
        }
        $initial_grade = array_reduce($grading_systems->toArray(), function($sum, $grading_system){
            $sum += $grading_system['weighted_score'];
            return $sum;
        }, 0);
        return [
            'unit_items' => $grading_systems,
            'initial_grade' => $initial_grade,
            'transmuted_grade' => TransmutedGrade::where('grade', '<=', $initial_grade)->orderBy('transmuted_grade', 'desc')->first()->transmuted_grade
        ];
    }

    
    private function calulateUnitScores($section_students, $class_record, $unit_id)
    {
        foreach ($section_students as $key => $section_student) {
            $grading_systems = $class_record->subject->subject_category->grading_systems->toArray();
            foreach ($grading_systems as $key => $grading_system) {
                $grading_systems[$key]['unit_scores'] = UnitScore::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->where('section_student_id', $section_student->id)->get();
                $grading_systems[$key]['total_scores'] = UnitScore::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->where('section_student_id', $section_student->id)->sum('score');
                $grading_systems[$key]['unit_items'] = UnitItem::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->sum('item');
                $grading_systems[$key]['count'] = count($grading_systems[$key]['unit_scores']);
                if($grading_systems[$key]['total_scores'] != 0 && $grading_systems[$key]['unit_items'] != 0){
                    $grading_systems[$key]['percentage_score'] = ($grading_systems[$key]['total_scores'] / $grading_systems[$key]['unit_items']) * 100;
                    $grading_systems[$key]['weighted_score'] = $grading_systems[$key]['percentage_score'] * $grading_systems[$key]['percentage'];

                    $grading_systems[$key]['percentage_score'] = number_format($grading_systems[$key]['percentage_score'], 2);
                    $grading_systems[$key]['weighted_score'] = number_format($grading_systems[$key]['weighted_score'], 2);

                    $grading_systems[$key]['percentage_grade'] = ($grading_systems[$key]['weighted_score'] / ($grading_systems[$key]['percentage'] * 100)) * 100;
                    $grading_systems[$key]['percentage_grade'] = number_format($grading_systems[$key]['percentage_grade'], 2);
                    
                    $percentage_grading_scale = GradingScale::where('transmuted_grade', '<=', $grading_systems[$key]['percentage_grade'])->orderBy('transmuted_grade', 'desc')->first();
                    $grading_systems[$key]['percentage_grade_descriptor'] = $percentage_grading_scale->descriptor;
                    $grading_systems[$key]['percentage_grade_remarks'] = $percentage_grading_scale->remarks;
                }else{
                    $grading_systems[$key]['percentage_score'] = 0;
                    $grading_systems[$key]['weighted_score'] = 0;
                    $grading_systems[$key]['percentage_grade'] = 0;
                    $grading_systems[$key]['percentage_grade_descriptor'] = "";
                    $grading_systems[$key]['percentage_grade_remarks'] = "";
                }
            }
            $section_student->grading_system = $grading_systems;
            $section_student->initial_grade = array_reduce($grading_systems, function($sum, $grading_system){
                $sum += $grading_system['weighted_score'];
                return $sum;
            }, 0);
            $section_student->total_items = array_reduce($grading_systems, function($sum, $grading_system){
                $sum += $grading_system['unit_items'];
                return $sum;
            }, 0);

            $section_student->transmuted_grade = TransmutedGrade::where('grade', '<=', $section_student->initial_grade)->orderBy('transmuted_grade', 'desc')->first()->transmuted_grade;

            $grading_scale = GradingScale::where('transmuted_grade', '<=', $section_student->transmuted_grade)->orderBy('transmuted_grade', 'desc')->first();
            $section_student->descriptor = $section_student->total_items != 0 ? $grading_scale->descriptor : "";
            $section_student->remarks = $section_student->total_items != 0 ? $grading_scale->remarks : "";

            $section_student->unit_action = UnitAction::with('action')->where('section_student_id', $section_student->id)->where('unit_id', $unit_id)->first();
        }
        return $section_students;
    }

    private function calulateUnitScoresStudent($section_student_id, $class_record, $unit_id)
    {
        $section_student = [];
        $grading_systems = $class_record->subject->subject_category->grading_systems->toArray();
        foreach ($grading_systems as $key => $grading_system) {
            $grading_systems[$key]['unit_scores'] = UnitScore::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->where('section_student_id', $section_student_id)->get();
            $grading_systems[$key]['total_scores'] = UnitScore::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->where('section_student_id', $section_student_id)->sum('score');
            $grading_systems[$key]['unit_items'] = UnitItem::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->sum('item');
            $grading_systems[$key]['count'] = count($grading_systems[$key]['unit_scores']);
            if($grading_systems[$key]['total_scores'] != 0){
                $grading_systems[$key]['percentage_score'] = ($grading_systems[$key]['total_scores'] / $grading_systems[$key]['unit_items']) * 100;
                $grading_systems[$key]['weighted_score'] = $grading_systems[$key]['percentage_score'] * $grading_systems[$key]['percentage'];
                
                $grading_systems[$key]['percentage_score'] = number_format($grading_systems[$key]['percentage_score'], 2);
                $grading_systems[$key]['weighted_score'] = number_format($grading_systems[$key]['weighted_score'], 2);

                $grading_systems[$key]['percentage_grade'] = ($grading_systems[$key]['weighted_score'] / ($grading_systems[$key]['percentage'] * 100)) * 100;
                $grading_systems[$key]['percentage_grade'] = number_format($grading_systems[$key]['percentage_grade'], 2);
                
                $percentage_grading_scale = GradingScale::where('transmuted_grade', '<=', $grading_systems[$key]['percentage_grade'])->orderBy('transmuted_grade', 'desc')->first();
                $grading_systems[$key]['percentage_grade_descriptor'] = $percentage_grading_scale->descriptor;
                $grading_systems[$key]['percentage_grade_remarks'] = $percentage_grading_scale->remarks;

            }else{
                $grading_systems[$key]['percentage_score'] = 0;
                $grading_systems[$key]['weighted_score'] = 0;
            }
        }
        $section_student['unit_id'] = $unit_id;
        // $section_student['grading_system'] = $grading_systems;
        $section_student['initial_grade'] = array_reduce($grading_systems, function($sum, $grading_system){
            $sum += $grading_system['weighted_score'];
            return $sum;
        }, 0);

        $section_student['total_items'] = array_reduce($grading_systems, function($sum, $grading_system){
            $sum += $grading_system['unit_items'];
            return $sum;
        }, 0);

        $section_student['transmuted_grade'] = TransmutedGrade::where('grade', '<=', $section_student['initial_grade'])->orderBy('transmuted_grade', 'desc')->first()->transmuted_grade;

        $grading_scale = GradingScale::where('transmuted_grade', '<=', $section_student['transmuted_grade'])->orderBy('transmuted_grade', 'desc')->first();
        $section_student['descriptor'] = $section_student['total_items'] != 0 ? $grading_scale->descriptor : "";
        $section_student['remarks'] = $section_student['total_items'] != 0 ? $grading_scale->remarks : "";
        return $section_student;
    }

    public function unitScore(Request $request, $id)
    {
        $with = [
            'subject.subject_category.grading_systems',
            'section.students' => function($query){
                $query->join('students', 'section_students.student_id', '=', 'students.id');
                $query->select(['section_students.*']);
                $query->orderBy('students.last_name');
                $query->orderBy('students.first_name');
                $query->orderBy('students.middle_name');
                $query->orderBy('students.ext_name');
                $query->with(['student.gender']);
            }
        ];

        $class_record = ClassRecord::with($with)->find($id);

        // return $class_record;

        if($request->section_student_id){
            $section_students = $class_record->section->students()->where('id', $request->section_student_id)->get();
        }else{
            $section_students = $class_record->section->students;
        }
        
        $section_students = $this->calulateUnitScores($section_students, $class_record, $request->unit_id);
        
        return [
            'section_students' => $section_students,
        ];
    }

    public function unitSummary(Request $request, $id)
    {
        $with = [
            'subject.subject_category.grading_systems',
            'quarters.units',
            'section.students' => function($query){
                $query->join('students', 'section_students.student_id', '=', 'students.id');
                $query->select(['section_students.*']);
                $query->orderBy('students.last_name');
                $query->orderBy('students.first_name');
                $query->orderBy('students.middle_name');
                $query->orderBy('students.ext_name');
                $query->with(['student.gender']);
            }
        ];

        $class_record = ClassRecord::with($with)->find($id);
        if($request->section_student_id){
            $section_students = $class_record->section->students()->where('id', $request->section_student_id)->get();
        }else{
            $section_students = $class_record->section->students;
        }


        if($request->class_record_quarter_id){
            
            $units = Unit::where('class_record_quarter_id', $request->class_record_quarter_id)->get()->toArray();
            foreach ($section_students as $section_student) {
                foreach ($units as $key => $unit) {
                    $calculated_scores = $this->calulateUnitScoresStudent($section_student->id, $class_record, $unit['id']);
                    $units[$key]['initial_grade'] = $calculated_scores['initial_grade'];
                    $units[$key]['transmuted_grade'] = $calculated_scores['transmuted_grade'];
                    $units[$key]['descriptor'] = $calculated_scores['descriptor'];
                    $units[$key]['remarks'] = $calculated_scores['remarks'];
                }
                $section_student->units = $units;
            }
            return [
                'section_students' => $section_students,
                'units' => $units,
            ];
        }

        return [
            'section_students' => $section_students,
        ];
    }

}
