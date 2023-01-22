<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\ClassRecord;
use App\Models\ClassRecordQuarter;
use App\Models\Library;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Unit;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sections = Section::with([
            'school_year',
            'grade_level',
            'track',
        ]);

        if($request->searchQuery){
            $searchQuery = $request->searchQuery;
            $sections->orWhere("section_name", "like", "%$searchQuery%");
        }

        $per_page = $request->perPage ?? 20;

        $sections = $sections->paginate($per_page);

        return $sections;
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
    public function store(SectionRequest $request)
    {
        $section = Section::create($request->all());

        $first_semester = Library::firstSemester();
        $second_semester = Library::secondSemester();

        $first_quarter = Library::firstQuarter();
        $second_quarter = Library::secondQuarter();
        $third_quarter = Library::thirdQuarter();
        $fourth_quarter = Library::fourthQuarter();

        $first_semester_curriculums = Subject::where('track_id', $section->track_id)
            ->where('grade_level_id', $section->grade_level_id)
            ->where('semester_id', $first_semester->id)
            ->get();
        $second_semester_curriculums = Subject::where('track_id', $section->track_id)
            ->where('grade_level_id', $section->grade_level_id)
            ->where('semester_id', $second_semester->id)
            ->get();
        $class_records = [];
        foreach ($first_semester_curriculums as $key => $subject) {
            $class_record = [
                'subject_id' => $subject->id,
            ];
            $class_records[] = new ClassRecord($class_record);
        }
        foreach ($second_semester_curriculums as $key => $subject) {
            $class_record = [
                'subject_id' => $subject->id,
            ];
            $class_records[] = new ClassRecord($class_record);
        }
        $section->class_records()->saveMany($class_records);

        $section->class_records->each(function ($class_record, $key) use ($first_semester, $second_semester, $first_quarter, $second_quarter, $third_quarter, $fourth_quarter) {

            if($class_record->subject->semester_id == $first_semester->id){
                $quarters = [
                    new ClassRecordQuarter(['quarter_id' => $first_quarter->id]),
                    new ClassRecordQuarter(['quarter_id' => $second_quarter->id]),
                ];
            }elseif($class_record->subject->semester_id == $second_semester->id){
                $quarters = [
                    new ClassRecordQuarter(['quarter_id' => $third_quarter->id]),
                    new ClassRecordQuarter(['quarter_id' => $fourth_quarter->id]),
                ];
            }else{
                abort(500);
            }
            $class_record->quarters()->saveMany($quarters);

            $class_record->quarters->each(function ($quarter, $key) {
                $units = [
                    new Unit(['name' => "Unit 1"]),
                    new Unit(['name' => "Unit 2"]),
                    new Unit(['name' => "Unit 3"]),
                    new Unit(['name' => "Unit 4"]),
                    new Unit(['name' => "Unit 5"]),
                ];
                $quarter->units()->saveMany($units);
            });
        });
        
        return $section;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $section = Section::find($id);
        $section->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Section::find($id)->delete();
    }
}
