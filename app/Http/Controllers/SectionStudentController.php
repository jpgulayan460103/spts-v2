<?php

namespace App\Http\Controllers;

use App\Models\SectionStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;

class SectionStudentController extends Controller
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
        $section_student_exist = SectionStudent::where('section_id', $request->section_id)->where('student_id', $request->student_id)->first();
        if($section_student_exist){
            abort(422);
        }else{
            $section_student = SectionStudent::create($request->all());
            return $section_student->load('student.gender');
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
        ];
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords($headers);

        $file_data = [];

        foreach ($records as $offset => $record) {
            $student = Student::where('student_id_number', $record['student_id_number'])->first();
            $student_id = null;
            if($student){
                $student_id = $student->id;
            }
            $file_data[] = [
                'id' => $student_id,
                'student_id_number' => $record['student_id_number'],
                'last_name' => $record['last_name'],
                'first_name' => $record['first_name'],
                'middle_name' => $record['middle_name'],
                'ext_name' => $record['ext_name'],
                'gender' => $record['gender'],
                'success' => null,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SectionStudent  $sectionStudent
     * @return \Illuminate\Http\Response
     */
    public function show(SectionStudent $sectionStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SectionStudent  $sectionStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(SectionStudent $sectionStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SectionStudent  $sectionStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SectionStudent $sectionStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectionStudent  $sectionStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return SectionStudent::find($id)->delete();
    }
}
