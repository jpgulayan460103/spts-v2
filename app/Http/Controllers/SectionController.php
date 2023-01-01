<?php

namespace App\Http\Controllers;

use App\Models\ClassRecord;
use App\Models\ClassRecordQuarter;
use App\Models\Library;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class SectionController extends Controller
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

        $section->class_records->each(function ($class_record, $key) use ($first_quarter, $second_quarter) {
            $quarters = [
                new ClassRecordQuarter(['quarter_id' => $first_quarter->id]),
                new ClassRecordQuarter(['quarter_id' => $second_quarter->id]),
            ];
            $class_record->quarters()->saveMany($quarters);
        });

        // $quarters = [
        //     new ClassRecordQuarter(['quarter_id' => $first_quarter->id]),
        //     new ClassRecordQuarter(['quarter_id' => $second_quarter->id]),
        // ];
        // $class_records[$key]->quarters()->saveMany($quarters);
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
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
