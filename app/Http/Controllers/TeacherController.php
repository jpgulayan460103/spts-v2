<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\ClassRecord;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teachers = Teacher::with(['gender','user']);
        if($request->searchQuery){
            $searchQuery = $request->searchQuery;
            $teachers->orWhere("teacher_id_number", "like", "%$searchQuery%");
            $teachers->orWhere("first_name", "like", "%$searchQuery%");
            $teachers->orWhere("middle_name", "like", "%$searchQuery%");
            $teachers->orWhere("last_name", "like", "%$searchQuery%");
            $teachers->orWhere("ext_name", "like", "%$searchQuery%");
        }

        $teachers = $teachers->paginate(20);

        return $teachers;
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
    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->all());
        $user_account = $request->only([
            'username',
            'password'
        ]);
        $user_account['account_type'] = "teacher";
        $teacher->user()->create($user_account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, $id)
    {
        $teacher = Teacher::find($id);
        $teacher->update($request->all());
        if($request->username){
            $data = [];
            if($request->password){
                $data['password'] = bcrypt($request->password);
            }
            $data['username'] = $request->username;

            $teacher->user()->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Teacher::find($id)->delete();
    }
    
    public function all(Request $request)
    {
        $teachers = Teacher::with(['gender']);
        if($request->searchQuery){
            $searchQuery = $request->searchQuery;
            $teachers->orWhere("teacher_id_number", "like", "%$searchQuery%");
            $teachers->orWhere("first_name", "like", "%$searchQuery%");
            $teachers->orWhere("middle_name", "like", "%$searchQuery%");
            $teachers->orWhere("last_name", "like", "%$searchQuery%");
            $teachers->orWhere("ext_name", "like", "%$searchQuery%");
        }

        $teachers->orderBy('last_name');
        $teachers->orderBy('first_name');
        $teachers->orderBy('middle_name');
        $teachers->orderBy('ext_name');

        $teachers = $teachers->get();

        return $teachers;
    }

    public function classRecords(Request $request, $id)
    {
        $class_records = ClassRecord::with([
            'subject.semester',
            'section.adviser',
            'section.adviser',
            'section.school_year',
            'section.grade_level',
            'section.track',
        ])->where('teacher_id', $id);

        $class_records = $class_records->paginate(20);

        return $class_records;
    }

    public function advisories(Request $request, $id)
    {
        $sections = Section::with([
            'school_year',
            'grade_level',
            'track',
            'adviser',
        ])->where('adviser_id', $id);

        if($request->searchQuery){
            $searchQuery = $request->searchQuery;
            $sections->orWhere("section_name", "like", "%$searchQuery%");
        }

        $per_page = $request->perPage ?? 20;

        $sections = $sections->paginate($per_page);

        return $sections;
    }
}
