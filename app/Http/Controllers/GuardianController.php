<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardianRequest;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $guardians =  Guardian::with(['gender','guardian','user']);
        
        if($request->searchQuery){
            $searchQuery = $request->searchQuery;

            $guardians->where(function($query) use ($searchQuery){
                $query->orWhere("guardian_id_number", "like", "%$searchQuery%");
                $query->orWhere("first_name", "like", "%$searchQuery%");
                $query->orWhere("middle_name", "like", "%$searchQuery%");
                $query->orWhere("last_name", "like", "%$searchQuery%");
                $query->orWhere("ext_name", "like", "%$searchQuery%");
            });
        }

        $per_page = $request->perPage ?? 20;

        $guardians->orderBy('last_name');
        $guardians->orderBy('first_name');
        $guardians->orderBy('middle_name');
        $guardians->orderBy('ext_name');

        $guardians = $guardians->paginate($per_page);

        return $guardians;
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
    public function store(GuardianRequest $request)
    {
        $guardian = Guardian::create($request->all());
        $user_account = $request->only([
            'username',
            'password'
        ]);
        $user_account['account_type'] = "guardian";
        $guardian->user()->create($user_account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function show(Guardian $guardian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function edit(Guardian $guardian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $guardian = Guardian::find($id);
        $guardian->update($request->all());
        if($request->username){
            $data = [];
            if($request->password){
                $data['password'] = bcrypt($request->password);
            }
            $data['username'] = $request->username;

            $guardian->user()->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Guardian::find($id)->delete();
    }

    public function all(Request $request)
    {
        $guardians = Guardian::with(['gender']);
        if($request->searchQuery){
            $searchQuery = $request->searchQuery;

            $guardians->where(function($query) use ($searchQuery){
                $query->orWhere("guardian_id_number", "like", "%$searchQuery%");
                $query->orWhere("first_name", "like", "%$searchQuery%");
                $query->orWhere("middle_name", "like", "%$searchQuery%");
                $query->orWhere("last_name", "like", "%$searchQuery%");
                $query->orWhere("ext_name", "like", "%$searchQuery%");
            });
        }

        $guardians->orderBy('last_name');
        $guardians->orderBy('first_name');
        $guardians->orderBy('middle_name');
        $guardians->orderBy('ext_name');

        $guardians = $guardians->get();

        return $guardians;
    }

    public function students(Request $request, $id)
    {
        $students = Student::with(['gender','user'])->where('guardian_id', $id);

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

        $students = $students->paginate($per_page);

        return $students;
    }
}
