<?php

namespace App\Http\Controllers;

use App\Models\SectionStudent;
use Illuminate\Http\Request;

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
