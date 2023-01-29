<?php

namespace App\Http\Controllers;

use App\Models\ClassRecord;
use App\Models\ClassRecordQuarter;
use App\Models\Library;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function index(Request $request)
    {
        $user = Auth::user();
        $data = [
            'user' => $user,
        ];
        switch ($user->account_type) {
            case 'admin':
                return view('sections', $data);
            case 'teacher':
                return view('dashboard-teacher', $data);
            case 'student':
            case 'guardian':
                if($request->stduid || $user->account_type == 'student'){

                    if($user->account_type == 'guardian'){
                        $student = Student::whereUuid($request->stduid)->first();
                        if($student){
                            $student_id = $student->id;
                        }else{
                            abort(404);
                        }
                    }else{
                        $student_id = $user->userable_id;
                    }
                    $section = "{}";
                    if($request->sctuid){
                        $section_uuid = $request->sctuid;
                        $section = Section::with([
                            'school_year',
                            'grade_level',
                            'track',
                            'adviser',
                        ])
                        ->whereUuid($section_uuid)
                        ->whereHas('students',function($query) use ($student_id){
                            $query->where('student_id', $student_id);
                        })
                        ->first();
    
                        if(!$section){
                            abort(404);
                        }
                    }
    
                    $data['section'] = $section;
                    $data['student'] = Student::with(['gender'])->find($student_id);
                    return view('dashboard-student', $data);
                }else{
                    return view('dashboard-guardian', $data);
                }
            default:
                # code...
                break;
        }
    }

    public function sections()
    {
        return view('sections');
    }

    public function students()
    {
        return view('students');
    }

    public function studentsImport(Request $request)
    {
        $data = [];
        $data['user'] = Auth::user();
        $data['genders'] = Library::where('library_type', 'genders')->get();
        return view('student-import', $data);
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

        $user = Auth::user();
        $data = [
            'user' => $user,
        ];

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

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Old Password didn\'t match');
                    }
                },
            ],
            'new_password' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/m|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ],[
            'new_password.regex' => "Must contain at least 1 uppercase, 1 lowercase, 1 numeric, and 1 special character."
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = $request->new_password;
        $user->save();

    }
}
