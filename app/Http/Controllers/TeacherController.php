<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
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
        $teachers = Teacher::with(['gender']);
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
        return Teacher::create($request->all());
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
}
