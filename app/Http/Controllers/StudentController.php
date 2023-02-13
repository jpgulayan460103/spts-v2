<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\ClassRecord;
use App\Models\GradingScale;
use App\Models\Library;
use App\Models\Section;
use App\Models\SectionStudent;
use App\Models\Student;
use App\Models\TransmutedGrade;
use App\Models\UnitAction;
use App\Models\UnitItem;
use App\Models\UnitScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students =  Student::with(['gender','guardian','user']);
        
        if($request->searchQuery){
            $searchQuery = $request->searchQuery;

            $students->where(function($query) use ($searchQuery){
                $query->orWhere("student_id_number", "like", "%$searchQuery%");
                $query->orWhere("first_name", "like", "%$searchQuery%");
                $query->orWhere("middle_name", "like", "%$searchQuery%");
                $query->orWhere("last_name", "like", "%$searchQuery%");
                $query->orWhere("ext_name", "like", "%$searchQuery%");
            });
        }

        $per_page = $request->perPage ?? 20;

        $students->orderBy('last_name');
        $students->orderBy('first_name');
        $students->orderBy('middle_name');
        $students->orderBy('ext_name');

        $students = $students->paginate($per_page)->toArray();

        return $students;
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
    public function store(StudentRequest $request)
    {
        $student = Student::create($request->all());
        $user_account = $request->only([
            'username',
            'password'
        ]);
        $user_account['account_type'] = "student";
        $student->user()->create($user_account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Student::with(['gender','guardian','user'])->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $student = Student::find($id);
        $student->update($request->all());
        if($request->username){
            $data = [];
            if($request->password){
                $data['password'] = bcrypt($request->password);
            }
            $data['username'] = $request->username;

            $student->user()->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();
    }

    public function sections(Request $request, $id)
    {
        $sections = Section::with([
            'school_year',
            'grade_level',
            'track',
            'adviser',
        ]);

        $sections->whereHas('students', function($query) use ($id){
            $query->where('student_id', $id);
        });

        if($request->searchQuery){
            $searchQuery = $request->searchQuery;
            $sections->where("section_name", "like", "%$searchQuery%");
        }

        $per_page = $request->perPage ?? 20;

        $sections = $sections->paginate($per_page);

        return $sections;
    }

    public function photo(Request $request, $id)
    {
        $validated = $request->validate([
            'photo' => 'file|max:15000|mimes:jpeg,jpg,png',
        ]);

        $student = Student::find($id);
        $file = request('photo');
        $file_uuid = Str::uuid();
        $filename = "$file_uuid.".$file->getClientOriginalExtension();
        $path = Storage::putFileAs("public", $file, $filename);
        $student->photo = $path;
        $student->save();
        return $this->show($id);
    }

    public function section(Request $request, $id, $section_id)
    {
        # code...
    }

    public function subjectSummary(Request $request, $id)
    {
        $subject_id = $request->subject_id;
        $section_id = $request->section_id;
        $student_id = $id;
        $class_record = ClassRecord::with(['quarters.units', 'quarters.quarter','teacher'])->where('subject_id', $subject_id)->where('section_id', $section_id)->first();
        $unit_summarries = [];

        $section_student = SectionStudent::with(['attendances.attendance'])->where('section_id', $section_id)->where('student_id', $student_id)->first();
        if($section_student){
            $class_record->attendances = $section_student->attendances()->with(['attendance'])->whereHas('attendance', function($query) use ($class_record){
                $query->where('class_record_id', $class_record->id);
            })->get();
            $class_record->present_days = $section_student->attendances()->whereHas('attendance', function($query) use ($class_record){
                $query->where('class_record_id', $class_record->id);
            })->sum('present_days');
            $class_record->week_days = $class_record->attendances()->where('class_record_id', $class_record->id)->sum('total_days');
        }else{
            abort(404);
        }

        if($class_record){
            $quarters = $class_record->quarters;
            foreach ($quarters as $quarter_key => $quarter) {
                $units = $quarter->units;
                foreach ($units as $unit_key => $unit) {
                    $unit->summary = $this->calulateUnitScoresStudent($section_student->id, $class_record, $unit->id);
                }
            }

        }else{
            abort(404);
        }

        return $class_record;
    }


    private function calulateUnitScoresStudent($section_student_id, $class_record, $unit_id)
    {
        $section_student = [];
        $grading_systems = $class_record->subject->subject_category->grading_systems->toArray();
        foreach ($grading_systems as $key => $grading_system) {
            // $grading_systems[$key]['unit_scores'] = UnitScore::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->where('section_student_id', $section_student_id)->get();
            // $grading_systems[$key]['count'] = count($grading_systems[$key]['unit_scores']);
            $grading_systems[$key]['total_scores'] = UnitScore::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->where('section_student_id', $section_student_id)->sum('score');
            $grading_systems[$key]['unit_items'] = UnitItem::where('unit_id', $unit_id)->where('grading_system_id', $grading_system['id'])->sum('item');
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

        $section_student['unit_action'] = UnitAction::with('action')->where('section_student_id', $section_student_id)->where('unit_id', $unit_id)->first();
        return $section_student;
    }

    public function export(Request $request, $type = null)
    {
        $disk = config('app.env') == "local" ? "local" : "sftp";
        $export_pages = 100;

        if (strtolower($type) == "create") {
            $datetime = Carbon::now();
            $filename = "export-students-" . $datetime->toDateString() . "-" . $datetime->format('H-i-s') . ".csv";
            $file_location = public_path("exports/$filename");
            $file = fopen($file_location, 'w+');
            
            $headers = [
                "student_id_number",
                "first_name",
                "middle_name",
                "last_name",
                "ext_name",
                "gender",
            ];
            
            fputcsv($file, $headers);
            fclose($file);

            $students = $this->index($request);

            return [
                'total_pages' => $students["last_page"],
                'filename' => $filename,
                'file_location' => $file_location,
            ];

        }elseif (strtolower($type) == "write") {
            // sleep(2);
            $filename = $request->filename;
            $file_location = $request->file_location;

            $students = $this->index($request);
            $students = $students['data'];

            $file = fopen(public_path("exports/$filename"), "a+");

            $for_export = [];

            foreach ($students as $student) {
                $for_export[] = [
                    $student["student_id_number"],
                    $student["first_name"],
                    $student["middle_name"],
                    $student["last_name"],
                    $student["ext_name"],
                    $student["gender"]["name"],
                ];
            }

            // return $for_export;

            foreach ($for_export as $export_data) {
                fputcsv($file, $export_data);
            }
            fclose($file);

            return [
                'page' => $request->page,
                'filename' => $filename,
            ];
        }elseif(strtolower($type) == "download"){
            $file_location = $request->file_location;
            return [
                'url' => $file_location
            ];
        }
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'file|max:15000|mimetypes:text/plain',
        ]);

        $file = request('file');
        $file_uuid = Str::uuid();
        $filename = "$file_uuid.".$file->getClientOriginalExtension();
        $path = Storage::putFileAs("public", $file, $filename);
        $csv = Reader::createFromPath(public_path(Storage::url($path)), 'r');
        $headers = [
            'student_id_number',
            'last_name',
            'first_name',
            'middle_name',
            'ext_name',
            'gender',
            'spts_account_id',
        ];
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords($headers);

        $file_data = [];

        foreach ($records as $offset => $record) {


            $gender = Library::where('library_type', 'genders')->where('name', $record['gender'])->first();
            if($gender){
                $gender_id = $gender->id;
            }else{
                $gender_id = null;
            }
            $password = $record['student_id_number'];

            $file_data[] = [
                'student_id_number' => $record['student_id_number'],
                'last_name' => $record['last_name'],
                'first_name' => $record['first_name'],
                'middle_name' => $record['middle_name'],
                'ext_name' => $record['ext_name'],
                'gender' => $record['gender'],
                'spts_account_id' => $record['spts_account_id'],
                'username' => $record['spts_account_id'],
                'gender_id' => $gender_id,
                'password' => $password,
            ];
        }

        $file_data = $this->safe_json_encode($file_data);

        $file_data = json_decode($file_data, true);

        return [
            'contents' => $file_data,
            'headers' => $headers
        ];
        return Storage::url($path);
    }

    private function utf8ize($d)
    {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string($d)) {
            return utf8_encode($d);
        }
        return $d;
    }

    private function safe_json_encode($value, $options = 0, $depth = 512)
    {
        $encoded = json_encode($value, $options, $depth);
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON'; // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = $this->utf8ize($value);
                return $this->safe_json_encode($clean, $options, $depth);
            default:
                return 'Unknown error'; // or trigger_error() or throw new Exception()

        }
    }
}
