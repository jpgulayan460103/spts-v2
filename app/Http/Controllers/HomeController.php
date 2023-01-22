<?php

namespace App\Http\Controllers;

use App\Models\ClassRecord;
use App\Models\ClassRecordQuarter;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sections()
    {
        return view('sections');
    }

    public function students()
    {
        return view('students');
    }
    public function guardians()
    {
        return view('guardians');
    }
    public function teachers()
    {
        return view('teachers');
    }

    public function manageSection(Request $request, $section_uuid, $type = null)
    {
        $with = [
            'school_year',
            'grade_level',
            'track',
            'adviser',
        ];

        $class_record = "{}";
        $class_record_quarter = "{}";
        $unit = "{}";
        $section = Section::query();
        if($type){
            switch ($type) {
                case 'students':
                    $with["students"] = function($query){
                        $query->join('students', 'section_students.student_id', '=', 'students.id');
                        $query->select(['section_students.*']);
                        $query->orderBy('students.last_name');
                        $query->orderBy('students.first_name');
                        $query->orderBy('students.middle_name');
                        $query->orderBy('students.ext_name');
                        $query->with(['student.gender', 'student.guardian']);
                    };
                    break;
                case 'class-records':
                    $with[] = "class_records.subject.semester";
                    $with[] = "class_records.teacher";
                    $with[] = "class_records.quarters.quarter";

                    $with["students"] = function($query){
                        $query->join('students', 'section_students.student_id', '=', 'students.id');
                        $query->select(['section_students.*']);
                        $query->orderBy('students.last_name');
                        $query->orderBy('students.first_name');
                        $query->orderBy('students.middle_name');
                        $query->orderBy('students.ext_name');
                        $query->with(['student.gender']);
                    };

                    if($request->cruid){
                        $class_record_uuid = $request->cruid;
                        $class_record = ClassRecord::with([
                            'subject.semester',
                            'teacher',
                            'subject.subject_category.grading_systems',
                            'quarters.quarter',
                        ])->whereUuid($class_record_uuid)->first();

                        if(!$class_record){
                            abort(404);
                        }
                    }

                    if($request->crquid){
                        
                        $class_record_quarter_uuid = $request->crquid;
                        $class_record_quarter = ClassRecordQuarter::with([
                            'quarter',
                            'units'
                        ])->whereUuid($class_record_quarter_uuid)->first();

                        if(!$class_record_quarter){
                            abort(404);
                        }
                        // return $class_record_quarter;
                    }

                    if($request->utuid){
                        
                        $unit_uuid = $request->utuid;
                        $unit = Unit::whereUuid($unit_uuid)->first();

                        if(!$unit){
                            abort(404);
                        }
                        // return $unit;
                    }

                    break;
                default:
                    abort(404);
                    break;
            }
        }

        $section = $section->with($with)->whereUuid($section_uuid)->first();
        if($section){
            $data['section'] = $section;
            // return $data;
            $data['type'] = $type;
            $data['class_record'] = $class_record;
            $data['class_record_quarter'] = $class_record_quarter;
            $data['unit'] = $unit;

            // return $data;
            
            return view('selected-section', $data);
        }else{
            abort(404);
        }
    }
}
